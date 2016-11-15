<?php

namespace AppBundle\Document;

use AppBundle\Model\Game as GameModel;
use AppBundle\Model\Player;
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
     * @var ArrayCollection
     */
    protected $tasks;

    /**
     * @var string
     */
    protected $currentTaskId;

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
     * @param string $taskId
     * @return Task
     */
    public function getTaskById($taskId)
    {
        return $this->getTasks()->filter(function(Task $task) use ($taskId) {
            if ($task->getId()===$taskId) {
                return true;
            }

            return false;
        })->first();
    }

    /**
     * @return Task
     */
    public function getCurrentTaskId()
    {
        return $this->currentTaskId;
    }

    /**
     * @param Task $currentTaskId
     */
    public function setCurrentTaskId($currentTaskId)
    {
        $this->currentTaskId = $currentTaskId;
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

    /**
     * @return Task
     */
    public function getCurrentTask()
    {
        return $this->getTaskById($this->getCurrentTaskId());
    }

    public function startGame()
    {
        $this->setStatus(self::STATUS_STARTED);
    }

}
