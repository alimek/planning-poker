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
    private $name;

    /**
     * @var string
     */
    private $gameId;

    /**
     * @param string $id
     * @param string $name
     * @param string $gameId
     */
    private function __construct(string $id, string $name, string $gameId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gameId = $gameId;
    }

    /**
     * @param TaskEvent $event
     *
     * @return Task
     */
    public static function createFromEvent(TaskEvent $event): Task
    {
        return new self($event->getTask()->getId(), $event->getTask()->getName(), $event->getGame()->getId());
    }

}