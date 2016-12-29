<?php
namespace AppBundle\DTO;

use AppBundle\Document\Player;

class Vote
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $player;

    /**
     * * @param string $value
     * @param string $player
     */
    private function __construct($value, $player)
    {
        $this->value = $value;
        $this->player = $player;
    }

    public static function createFromValueAndPlayer(string $value, Player $player) {
        return new self($value, $player->getGuid());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getPlayer(): string
    {
        return $this->player;
    }



}