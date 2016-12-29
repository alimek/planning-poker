<?php
namespace AppBundle\Event;

use AppBundle\Document\Game;
use AppBundle\Document\Player;
use AppBundle\Document\Task;
use Symfony\Component\EventDispatcher\Event;

class CardPickEvent extends Event
{
    /**
     * @var Game
     */
    private $game;

    /**
     * @var Task
     */
    private $task;

    /**
     * @var string
     */
    private $vote;

    /**
     * @var Player
     */
    private $player;

    /**
     * @param Game $game
     * @param Task $task
     * @param string $vote
     * @param Player $player
     */
    public function __construct(Game $game, Task $task, string $vote, Player $player)
    {
        $this->game = $game;
        $this->task = $task;
        $this->vote = $vote;
        $this->player = $player;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @return string
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }
}