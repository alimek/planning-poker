<?php

namespace AppBundle\Document;

use AppBundle\Model;
use Doctrine\Common\Collections\ArrayCollection;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_FLIPED = 'flipped';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var ArrayCollection
     */
    protected $votes;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
        $this->votes = new ArrayCollection();
        $this->status = self::STATUS_NEW;
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
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @param Model\Task $task
     * @return Task
     */
    public static function fromModel(Model\Task $task): Task
    {
        return new self($task->getName());
    }

    /**
     * @return ArrayCollection|Vote[]
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param Vote $vote
     */
    public function replaceVote(Vote $vote) {
        $existingVote = $this->getVoteByPlayerGUID($vote->getPlayer()->getGuid());

        if(!$existingVote instanceof Vote) {
            $this->votes->add($vote);
        } else {
            $existingVote->setValue($vote->getValue());
        }
    }

    public function getVoteByPlayerGUID(string $playerGUID)
    {
        return $this->votes->filter(function(Vote $vote) use ($playerGUID) {
            if ($vote->getPlayer()->getGuid() === $playerGUID) {
                return true;
            }

            return false;
        })->first();
    }


}
