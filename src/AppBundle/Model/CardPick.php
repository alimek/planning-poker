<?php
namespace AppBundle\Model;

class CardPick
{
    /**
     * @var string
     */
    private $taskId;

    /**
     * @var string
     */
    private $vote;

    /**
     * @return string
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param string $taskId
     */
    public function setTaskId(string $taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * @param string $vote
     */
    public function setVote(string $vote)
    {
        $this->vote = $vote;
    }



}