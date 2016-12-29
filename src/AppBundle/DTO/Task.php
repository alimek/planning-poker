<?php
namespace AppBundle\DTO;

use AppBundle\Event\TaskEvent;

class Task
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $gameId;

    /**
     * @var Vote[]
     */
    private $votes;

    /**
     * @param string $id
     * @param string $name
     * @param string $gameId
     * @param string $status
     */
    private function __construct(string $id, string $name, string $gameId, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gameId = $gameId;
        $this->votes = [];
        $this->status = $status;
    }

    /**
     * @param TaskEvent $event
     *
     * @return Task
     */
    public static function createFromEvent(TaskEvent $event): Task
    {
        $eventTask = $event->getTask();
        $eventGame = $event->getGame();

        $task = new self($eventTask->getId(), $eventTask->getName(), $eventGame->getId(), $eventTask->getStatus());

        foreach($eventGame->getTaskById($eventTask->getId())->getVotes() as $vote) {
            $task->votes[] = Vote::createFromValueAndPlayer($vote->getValue(), $vote->getPlayer());
        }

        return $task;
    }

}