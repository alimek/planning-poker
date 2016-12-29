<?php
namespace AppBundle\Event;

use AppBundle\Document\Player;
use AppBundle\Model\DropoutMessage;
use Symfony\Component\EventDispatcher\Event;

class PlayerStatusChangedEvent extends Event
{
    /**
     * @var string
     */
    private $playerGUID;

    /**
     * @param string $playerGUID
     */
    private function __construct($playerGUID)
    {
        $this->playerGUID = $playerGUID;
    }

    /**
     * @param DropoutMessage $dropoutMessage
     *
     * @return PlayerStatusChangedEvent
     */
    public static function createFromDropoutMessage(DropoutMessage $dropoutMessage)
    {
        return new self($dropoutMessage->getPlayerID());
    }

    /**
     * @param Player $player
     *
     * @return PlayerStatusChangedEvent
     */
    public static function createFromPlayer(Player $player) {
        return new self($player->getGuid());
    }

    /**
     * @return string
     */
    public function getPlayerGUID(): string
    {
        return $this->playerGUID;
    }

}