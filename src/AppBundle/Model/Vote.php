<?php

namespace AppBundle\Model;

class Vote
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $player;

    /**
     * @var Task
     */
    protected $task;

    /**
     * @var int
     */
    protected $value;

    /**
     * @return string
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param string $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    
}
