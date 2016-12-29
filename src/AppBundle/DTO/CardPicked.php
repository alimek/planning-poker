<?php
namespace AppBundle\DTO;

use AppBundle\Event\CardPickEvent;

class CardPicked
{
    /**
     * @var string
     */
    private $game;

    /**
     * @var string
     */
    private $player;

    /**
     * @var string
     */
    private $task;

    /**
     * @param string $game
     * @param string $player
     * @param string $task
     */
    public function __construct($game, $player, $task)
    {
        $this->game = $game;
        $this->player = $player;
        $this->task = $task;
    }

    public static function createFromEvent(CardPickEvent $event) {
        $dto = new self(
            $event->getGame()->getId(),
            $event->getPlayer()->getGuid(),
            $event->getTask()->getId()
        );

        return $dto;
    }

    /**
     * @return string
     */
    public function getGame(): string
    {
        return $this->game;
    }

    /**
     * @return string
     */
    public function getPlayer(): string
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getTask(): string
    {
        return $this->task;
    }
}