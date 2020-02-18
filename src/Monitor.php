<?php

namespace WorkerMonitor;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use PhpAmqpLib\Message\AMQPMessage;
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
            $response = $this->client->post('/'.$this->config->getApiEnv().self::MESSAGE_ENDPOINT, [
                RequestOptions::HEADERS => [
                    'x-api-key' => $this->config->getApiKey(),
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                RequestOptions::BODY => MessageConverter::convertDataForRequest($message),
            ]);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        }

        return $response->getStatusCode() === 200;
    }
}
