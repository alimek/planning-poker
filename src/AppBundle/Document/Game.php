<?php

namespace AppBundle\Document;

use AppBundle\Model\Player;
use AppBundle\Model\Game as GameModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Game
{
    const STATUS_NEW = 'new';
    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';

    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $players;

    /**
     * @var Collection
     */
    protected $tasks;

    /**
     * @var Task
     */
    protected $currentTask;

    /**
     * @var string
     */
    protected $status;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->status = Game::STATUS_NEW;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param GameModel $game
     * @return Game
     */
    public static function fromModel(GameModel $game)
    {
        return new self($game->getName());
    }

    /**
     * @return ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        $this->players->add($player);
    }

    /**
     * @return Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task)
    {
        $this->tasks->add($task);
    }

    /**
     * @return Task
     */
    public function getCurrentTask()
    {
        return $this->currentTask;
    }

    /**
     * @param Task $currentTask
     */
    public function setCurrentTask($currentTask)
    {
        $this->currentTask = $currentTask;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
}
