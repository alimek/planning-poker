<?php

namespace AppBundle\Util\Client;

use Bunny\Channel;
use Bunny\Client;

class RabbitClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Channel
     */
    protected $channel;

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
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
