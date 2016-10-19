<?php

namespace AppBundle\Util\Client;

use Bunny\Channel;

class ChannelFactory
{
    /**
     * @param RabbitClient $client
     * @param string $channelId
     * @return Channel
     */
    public static function create(RabbitClient $client, $channelId)
    {
        $channel = new Channel($client->getClient(), $channelId);
        return $channel;
    }
}
