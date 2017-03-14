<?php

namespace PGS\RabbitMQBundle\Service;

use PGS\RabbitMQBundle\Publisher\PGSMessage;

class RabbitMQPublisher
{
    /**
     * @var RabbitMQClient
     */
    private $client;

    //TODO: dodać service zarządzający exchange'ami


    /**
     * @param RabbitMQClient $client
     */
    public function __construct(RabbitMQClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param PGSMessage $message
     */
    public function publish(PGSMessage $message)
    {
        $channel = $this->client->getClient()->channel();
        $channel->exchangeDeclare($message->getExchange(), $message->getExchangeType());
        $channel->publish($message->getBody(), $message->getHeaders(), $message->getExchange(), $message->getRoutingKey());
    }
}