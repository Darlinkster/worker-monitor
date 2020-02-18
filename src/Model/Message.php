<?php


namespace WorkerMonitor\Model;


class Message
{
    /**
     * id obsahu ktereho se tyce, napr. nid nodu, nebo tid taxonomie atd
     *
     * @var string
     */
    private $contentId;

    /**
     * uid pro message
     *
     * @var string
     */
    private $messageId;

    /**
     * @var \DateTime
     */
    private $messageDate;

    /**
     * typ obsahu, kteremu patri contentId, napr, article, video, special
     *
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $queueName;

    /**
     * @var string
     */
    private $exchangeName;

    /**
     * typ zpravy, je potreba vymyslet, napr node-save, nebo crop-missing
     *
     * @var string
     */
    private $messageType;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $errorText;

    /**
     * jestli ma smysl poslat message do fronty znovu, tj, pokud lze udelat nejakou uzivatelskou akci,
     * ktera problem proc message neprosla vyresi a bude mit smysl pak poslat zpravu opet do fronty
     *
     * @var bool
     */
    private $requeueable = false;

    /**
     * @return string
     */
    public function getContentId(): string
    {
        return $this->contentId;
    }

    /**
     * @param string $contentId
     */
    public function setContentId(string $contentId)
    {
        $this->contentId = $contentId;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     */
    public function setMessageId(string $messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @return \DateTime
     */
    public function getMessageDate(): \DateTime
    {
        return $this->messageDate;
    }

    /**
     * @param \DateTime $messageDate
     */
    public function setMessageDate(\DateTime $messageDate)
    {
        $this->messageDate = $messageDate;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }

    /**
     * @param string $queueName
     */
    public function setQueueName(string $queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * @return string
     */
    public function getExchangeName(): string
    {
        return $this->exchangeName;
    }

    /**
     * @param string $exchangeName
     */
    public function setExchangeName(string $exchangeName)
    {
        $this->exchangeName = $exchangeName;
    }

    /**
     * @return string
     */
    public function getMessageType(): string
    {
        return $this->messageType;
    }

    /**
     * @param string $messageType
     */
    public function setMessageType(string $messageType)
    {
        $this->messageType = $messageType;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getErrorText(): string
    {
        return $this->errorText;
    }

    /**
     * @param string $errorText
     */
    public function setErrorText(string $errorText)
    {
        $this->errorText = $errorText;
    }

    /**
     * @return bool
     */
    public function isRequeueable(): bool
    {
        return $this->requeueable;
    }

    /**
     * @param bool $requeueable
     */
    public function setRequeueable(bool $requeueable)
    {
        $this->requeueable = $requeueable;
    }
}
