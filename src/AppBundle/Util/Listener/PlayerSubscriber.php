<?php
namespace AppBundle\Util\Listener;

use AppBundle\DTO\CardPicked;
use AppBundle\DTO\PlayerJoined;
use AppBundle\Event\CardPickEvent;
use AppBundle\Event\PlayerEvent;
use AppBundle\Event\PlayerStatusChangedEvent;
use AppBundle\Events;
use AppBundle\Repositories\PlayerRepository;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Publisher\PGSMessage;
use PGS\RabbitMQBundle\Service\RabbitMQPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlayerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var RabbitMQPublisher
     */
    private $publisher;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @param Serializer $serializer
     * @param RabbitMQPublisher $publisher
     * @param PlayerRepository $playerRepository
     */
    public function __construct(
        Serializer $serializer,
        RabbitMQPublisher $publisher,
        PlayerRepository $playerRepository
    )
    {
        $this->serializer = $serializer;
        $this->publisher = $publisher;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PLAYER_JOINED_GAME => 'onPlayerJoined',
            Events::PLAYER_PICKED_CARD => 'onCardPicked',
            Events::PLAYER_DROPOUT => 'onPlayerDropout',
            Events::PLAYER_ONLINE => 'onPlayerOnline'
        ];
    }

    /**
     * @param CardPickEvent $event
     */
    public function onCardPicked(CardPickEvent $event)
    {
        $cardPick = CardPicked::createFromEvent($event);
        $serializedCardPick = $this->serializer->serialize($cardPick, 'json');

        $message = PGSMessage::createTopicMessage($serializedCardPick, 'poker', 'player.cardpicked');
        $this->publisher->publish($message);
    }

    /**
     * @param PlayerEvent $event
     */
    public function onPlayerJoined(PlayerEvent $event)
    {
        $playerJoined = PlayerJoined::createFromEvent($event);
        $serializedTask = $this->serializer->serialize($playerJoined, 'json');

        $message = PGSMessage::createTopicMessage($serializedTask, 'poker', 'player.joined');
        $this->publisher->publish($message);
    }

    /**
     * @param PlayerStatusChangedEvent $event
     */
    public function onPlayerOnline(PlayerStatusChangedEvent $event)
    {
        $player = $this->playerRepository->getPlayerByGUID($event->getPlayerGUID());
        $player->setOffline(false);
        $this->playerRepository->save($player);
    }

    /**
     * @param PlayerStatusChangedEvent $event
     */
    public function onPlayerDropout(PlayerStatusChangedEvent $event)
    {
        $player = $this->playerRepository->getPlayerByGUID($event->getPlayerGUID());
        $player->setOffline(true);
        $this->playerRepository->save($player);
    }
}