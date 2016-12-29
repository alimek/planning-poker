<?php
/**
 * Created by PhpStorm.
 * User: grzegorz
 * Date: 23.11.16
 * Time: 12:22
 */

namespace AppBundle\Model;

class DropoutMessage
{
    /**
     * @var string
     */
    private $playerID;

    /**
     * @var string
     */
    private $gameID;

    /**
     * @return string
     */
    public function getPlayerID(): string
    {
        return $this->playerID;
    }

    /**
     * @param string $playerID
     */
    public function setPlayerID(string $playerID)
    {
        $this->playerID = $playerID;
    }

    /**
     * @return string
     */
    public function getGameID(): string
    {
        return $this->gameID;
    }

    /**
     * @param string $gameID
     */
    public function setGameID(string $gameID)
    {
        $this->gameID = $gameID;
    }

}