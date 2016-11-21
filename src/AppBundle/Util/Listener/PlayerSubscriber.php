<?php
namespace AppBundle\Util\Listener;

use AppBundle\DTO\PlayerJoined;
use AppBundle\Event\PlayerEvent;
use AppBundle\Events;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Service\RabbitMQPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlayerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var RabbitMQPublisher
     */
    protected $publisher;

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
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PLAYER_JOINED_GAME => 'onPlayerJoined',
        ];
    }

    /**
     * @param PlayerEvent $event
     */
    public function onPlayerJoined(PlayerEvent $event)
    {
        $playerJoined = PlayerJoined::createFromEvent($event);
        $serializedTask = $this->serializer->serialize($playerJoined, 'json');

        $this->publisher->publish(
            'poker',
            'player.joined',
            $serializedTask
        );
    }
}