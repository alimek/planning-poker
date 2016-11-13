<?php

namespace PGS\RabbitMQBundle\Service;

class ExchangeService
{
    /**
     * @var RabbitMQClient
     */
    private $client;

    public function __construct(RabbitMQClient $client)
    {
        $this->client = $client;
    }
}
