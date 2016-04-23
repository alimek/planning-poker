<?php

namespace AppBundle\Model;

class Game
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public static function create()
    {
        $game = new self();
        $game->setHash(uniqid('', true));
        return $game;
    }

}
