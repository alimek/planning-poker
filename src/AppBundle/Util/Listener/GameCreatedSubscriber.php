<?php

namespace AppBundle\Util\Listener;

use AppBundle\Event\GameEvent;
use AppBundle\Events;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Publisher\PGSMessage;
use PGS\RabbitMQBundle\Service\RabbitMQPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GameCreatedSubscriber implements EventSubscriberInterface
{
    /**
     * @var RabbitMQPublisher
     */
    private $publisher;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param RabbitMQPublisher $publisher
     * @param Serializer $serializer
     */
    public function __construct(RabbitMQPublisher $publisher, Serializer $serializer)
    {
        $this->publisher = $publisher;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::GAME_CREATED => 'onGameCreated',
        ];
    }

    /**
     * @param GameEvent $event
     */
    public function onGameCreated(GameEvent $event)
    {
        $message = PGSMessage::createTopicMessage($this->serializer->serialize($event->getGame(), 'json'), 'poker', 'game.created');
        $this->publisher->publish($message);
    }
}