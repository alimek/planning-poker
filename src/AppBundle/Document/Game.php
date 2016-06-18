<?php

namespace AppBundle\Document;

use AppBundle\Model;
use Doctrine\Common\Collections\Collection;

class Game
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    protected $userStories;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
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
     * @param Model\Game $game
     * @return Game
     */
    public static function fromModel(Model\Game $game)
    {
        return new self($game->getName());
    }
}
