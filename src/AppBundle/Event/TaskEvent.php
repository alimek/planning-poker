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
    protected $game;

    /**
     * @param Task $task
     * @param Game $game
     */
    public function __construct(Task $task, Game $game)
    {
        $this->task = $task;
        $this->game = $game;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }


}
