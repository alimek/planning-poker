<?php
namespace AppBundle\DTO;

use AppBundle\Event\PlayerEvent;

class PlayerJoined
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $guid;

    /**
     * @var string
     */
    private $email;

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
     * @param string $guid
     * @param string $email
     * @param string $name
     * @param string $gameId
     */
    private function __construct(string $id, string $guid, $email, string $name, string $gameId)
    {
        $this->id = $id;
        $this->guid = $guid;
        $this->email = $email;
        $this->name = $name;
        $this->gameId = $gameId;
    }

    /**
     * @param PlayerEvent $event
     *
     * @return PlayerJoined
     */
    public static function createFromEvent(PlayerEvent $event): PlayerJoined
    {
        $player = $event->getPlayer();
        $game = $event->getGame();

        return new self($player->getId(), $player->getGuid(), $player->getEmail(), $player->getName(), $game->getId());
    }
}