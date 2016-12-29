<?php
namespace PGS\RabbitMQBundle\Publisher;

use PGS\RabbitMQBundle\ExchangeType;

class PGSMessage
{
    /**
     * @var string
     */
    private $exchange;

    /**
     * @var string
     */
    private $exchangeType;

    /**
     * @var string
     */
    private $queue;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $topic;

    /**
     * @param string $body
     * @param string $exchange
     */
    private function __construct(string $body, string $exchange)
    {
        $this->body = $body;
        $this->exchange = $exchange;
        $this->headers = [];
    }

    /**
     * @param string $body
     * @param string $exchange
     * @param string $routingKey
     *
     * @return PGSMessage
     */
    public static function createDirectMessage(string $body, string $exchange, string $routingKey) {
        $message = new self($body, $exchange);
        $message->topic = $routingKey;
        $message->exchangeType = ExchangeType::DIRECT;
        return $message;
    }

    /**
     * @param string $body
     * @param string $exchange
     * @param string $topic
     *
     * @return PGSMessage
     */
    public static function createTopicMessage(string $body, string $exchange, string $topic) {
        $message = new self($body, $exchange);
        $message->topic = $topic;
        $message->exchangeType = ExchangeType::TOPIC;
        return $message;
    }

    /**
     * @param string $body
     * @param string $exchange
     *
     * @return PGSMessage
     */
    public static function createFanoutMessage(string $body, string $exchange) {
        $message = new self($body, $exchange);
        $message->exchangeType = ExchangeType::FANOUT;
        return $message;

    }

    /**
     * @param string $body
     * @param string $exchange
     * @param $headers
     *
     * @return PGSMessage
     */
    public static function createHeadersMessage(string $body, string $exchange, $headers) {
        $message = new self($body, $exchange);

        $message->headers = $headers; //TODO: headers jako osobny model (ze statycznymi funkcjami i stałymi) może w kolekcji

        $message->exchangeType = ExchangeType::HEADERS;
        return $message;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @return string
     */
    public function getExchangeType(): string
    {
        return $this->exchangeType;
    }

    /**
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->topic;
    }


}