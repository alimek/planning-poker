<?php
/**
 * Created by PhpStorm.
 * User: grzegorz
 * Date: 23.11.16
 * Time: 11:02
 */

namespace PGS\RabbitMQBundle\Service;

use Bunny\Message;

interface QueueConsumerInterface
{
    /**
     * @param Message $message
     *
     * @return bool
     */
    public function consume(Message $message);
}