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
    protected $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return Game
     */
    public static function create($name)
    {
        $game = new self();
        $game->setName($name);
        return $game;
    }

}
