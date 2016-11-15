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
    private function __construct($id, $name, $gameId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gameId = $gameId;
    }

    public static function createFromEvent(TaskEvent $event): Task
    {
        return new self($event->getTask()->getId(), $event->getTask()->getName(), $event->getGame()->getId());
    }

}