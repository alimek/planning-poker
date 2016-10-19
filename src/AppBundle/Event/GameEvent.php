<?php

namespace AppBundle\Event;

use AppBundle\Document\Game;
use Symfony\Component\EventDispatcher\Event;

class GameEvent extends Event
{
    /**
     * @var Game
     */
    private $game;

    /**
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }
}