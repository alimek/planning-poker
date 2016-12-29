<?php

namespace AppBundle\Util\Service;

use AppBundle\Event\PlayerStatusChangedEvent;
use AppBundle\Events;
use AppBundle\Model\DropoutMessage;
use AppBundle\Repositories\GameRepository;
use AppBundle\Repositories\PlayerRepository;
use Bunny\Message;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Service\QueueConsumerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DropoutMessageConsumerService implements QueueConsumerInterface
{
    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * * @param GameRepository $gameRepository
     * @param PlayerRepository $playerRepository
     * @param Serializer $serializer
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        GameRepository $gameRepository,
        PlayerRepository $playerRepository,
        Serializer $serializer,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Message $message
     *
     * @return bool|string
     */
    public function consume(Message $message)
    {
        try {
            $dropoutMessage = $this->serializer->deserialize($message->content, DropoutMessage::class, 'json');
            $event = PlayerStatusChangedEvent::createFromDropoutMessage($dropoutMessage);
            $this->eventDispatcher->dispatch(Events::PLAYER_DROPOUT, $event);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }
}
