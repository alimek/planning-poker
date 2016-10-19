<?php

namespace PGS\RabbitMQBundle\Service;

use Bunny\Channel;

class RabbitMQPublisher
{
    /**
     * @var RabbitMQClient
     */
    private $client;

    public function __construct(RabbitMQClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $exchange
     * @param string $queue
     * @param string $message
     * @param array $headers
     */
    public function publish($exchange, $queue, $message, array $headers = [])
    {
        $channel = $this->client->getClient()->channel();
        $channel->queueDeclare($queue);

        $channel->publish($message, $headers, $exchange, $queue);
    }
}