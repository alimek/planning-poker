<?php

namespace AppBundle\Document;

use AppBundle\Model\Game as GameModel;
use Doctrine\Common\Collections\ArrayCollection;

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
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->status = Game::STATUS_NEW;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param GameModel $game
     * @return Game
     */
    public static function fromModel(GameModel $game): Game
    {
        return new self($game->getName());
    }

    /**
     * @return ArrayCollection
     */
    public function getPlayers(): ArrayCollection
    {
        return $this->players;
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        if (!$this->players->exists(function ($key, $element) use ($player) {
            return $player->getGuid() === $element->getGuid();
        })
        ) {
            $this->players->add($player);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks(): ArrayCollection
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
    public function getTaskById(string $taskId): Task
    {
        return $this->getTasks()->filter(function(Task $task) use ($taskId) {
            if ($task->getId()===$taskId) {
                return true;
            }

            return false;
        })->first();
    }

    /**
     * @return string
     */
    public function getCurrentTaskId(): string
    {
        return $this->currentTaskId;
    }

    /**
     * @param Task $currentTaskId
     */
    public function setCurrentTaskId(Task $currentTaskId)
    {
        $this->currentTaskId = $currentTaskId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return Task
     */
    public function getCurrentTask(): Task
    {
        return $this->getTaskById($this->getCurrentTaskId());
    }

    public function startGame()
    {
        $this->setStatus(self::STATUS_STARTED);
    }

}
