<?php
namespace AppBundle\Event;

use AppBundle\Document\Game;
use AppBundle\Document\Player;
use Symfony\Component\EventDispatcher\Event;

class PlayerEvent extends Event
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var Game
     */
    private $game;

    /**
     * @param Player $player
     * @param Game $game
     */
    public function __construct(Player $player, Game $game)
    {
        $this->player = $player;
        $this->game = $game;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }
}