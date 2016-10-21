<?php

namespace AppBundle\Event;

use AppBundle\Document\Game;
use AppBundle\Document\Task;
use Symfony\Component\EventDispatcher\Event;

class TaskEvent extends Event
{
    /**
     * @var Task
     */
    protected $task;
    /**
     * @var Game
     */
    private $game;

    /**
     * @param Game $game
     * @param Task $task
     */
    public function __construct(Game $game, Task $task)
    {
        $this->task = $task;
        $this->game = $game;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }
}
