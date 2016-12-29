<?php

namespace AppBundle\Document;

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
     * @var int
     */
    protected $value;

    /**
     * @param Player $player
     * @param int $value
     */
    public function __construct(Player $player, $value)
    {
        $this->player = $player;
        $this->value = $value;
    }

    /**
     * @return Player
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
