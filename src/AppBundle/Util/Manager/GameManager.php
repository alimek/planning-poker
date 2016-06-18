<?php

namespace AppBundle\Util\Manager;

use AppBundle\Document\Game;
use AppBundle\Repositories\GameRepository;
use JMS\Serializer\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class GameManager
{
    /**
     * @var ProducerInterface
     */
    protected $producer;

    /**
     * @var GameRepository
     */
    protected $gameRepository;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param ProducerInterface $producer
     * @param GameRepository $gameRepository
     * @param Serializer $serializer
     */
    public function __construct(ProducerInterface $producer, GameRepository $gameRepository, Serializer $serializer)
    {
        $this->producer = $producer;
        $this->gameRepository = $gameRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param Game $game
     */
    public function startGame(Game $game)
    {
        $game->setStatus(Game::STATUS_STARTED);
        $game->setCurrentTaskId($game->getTasks()->first()->getId());
        $this->gameRepository->save($game);
        $this->producer->publish($this->serializer->serialize($game, 'json'));
    }

}
