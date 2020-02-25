<?php

namespace WorkerMonitor;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use WorkerMonitor\Converter\MessageConverter;
use WorkerMonitor\Model\Config;
use WorkerMonitor\Model\Message;

class Monitor
{
    /** @var string */
    const MESSAGE_ENDPOINT = '/messages';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $this->config->getApiUrl()
        ]);
    }

    /**
     * @param AMQPMessage $message
     * @return Message
     */
    public function convertMessage(AMQPMessage $message): Message
    {
        return MessageConverter::convertAMQPMessageToMessage($message);
    }

    /**
     * @param Message $message
     *
     * @return bool
     */
    public function sendMessageToApi(Message $message): bool
    {
        try {
            $apiKey = $this->config->getApiKey();
            $headers = [
                'x-api-key' => $apiKey,
                'Content-type' => 'application/json',
                'Accept' => 'application/json',
            ];
            $body = MessageConverter::convertDataForRequest($message);
            $uri = '/'.$this->config->getApiEnv().self::MESSAGE_ENDPOINT;
            $headersExport = $headers;
            $headersExport['x-api-key'] = substr($apiKey, 0, 3).str_pad('', strlen($apiKey) - 6,'*').substr($apiKey, -3, 3);

            $this->log('ApiUrl: {apiUrl} Uri: {uri} Headers: {headers} Body: {body}', [
                'apiUrl' => $this->config->getApiUrl(),
                'uri' => $uri,
                'headers' => var_export($headersExport, true),
                'body' => $body
            ]);

            $response = $this->client->post($uri, [
                RequestOptions::HEADERS => $headers,
                RequestOptions::BODY => $body,
            ]);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        }

        $this->log('Code: {code} Message: {message}', ['message' => (string) $response->getBody(), 'code' => $response->getStatusCode()]);

        return $response->getStatusCode() === 200;
    }

    private function log(string $message, array $context = []) {
        $logger = $this->config->getLogger();
        if ($logger instanceof LoggerInterface) {
            $logger->info('[WorkerMonitor] '.$message, $context);
        }
    }
}
