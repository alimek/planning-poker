<?php

namespace PGS\RabbitMQBundle\Service;

use Bunny\Client;
use React\Promise;
use React\Promise\PromiseInterface;

class RabbitMQClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param string $host
     * @param string $vhost
     * @param string $user
     * @param string $password
     */
    public function __construct($host, $vhost, $user, $password)
    {
        $options = [
            'host'      => $host,
            'vhost'     => $vhost,
            'user'      => $user,
            'password'  => $password,
        ];

        $this->client = new Client($options);
        $this->client->connect();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}