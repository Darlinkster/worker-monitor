<?php

namespace WorkerMonitor\Converter;

use PhpAmqpLib\Message\AMQPMessage;
use WorkerMonitor\Model\Message;

class MessageConverter
{
    /**
     * @param Message $message
     *
     * @return string
     */
    public static function convertDataForRequest(Message $message): string
    {
        $messageData = [
            'contentId' => $message->getContentId(),
            'messageId' => $message->getMessageId(),
            'messageDate' => $message->getMessageDate()->format(\DateTime::ATOM),
            'contentType' => $message->getContentType(),
            'queueName' => $message->getQueueName(),
            'exchangeName' => $message->getExchangeName(),
            'messageType' => $message->getMessageType(),
            'message' => $message->getMessage(),
            'errorText' => $message->getErrorText(),
            'requeueable' => $message->isRequeueable(),
        ];

        return \GuzzleHttp\json_encode($messageData);
    }

    public static function convertAMQPMessageToMessage(AMQPMessage $amqMessage): Message
    {
        $message = new Message();
        $message->setContentId('-');
        $message->setMessageId(uniqid('', true));
        $message->setMessageDate(new \DateTime());
        $message->setContentType('-');
        $message->setQueueName((string) $amqMessage->delivery_info['routing_key']);
        $message->setExchangeName((string) $amqMessage->delivery_info['exchange']);
        $message->setMessageType('-');
        $message->setMessage($amqMessage->getBody());
        $message->setErrorText('-');
        $message->setRequeueable(false);

        return $message;
    }
}
