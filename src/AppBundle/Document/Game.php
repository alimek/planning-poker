<?php

namespace AppBundle\Document;

use AppBundle\Model;

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
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param Model\Game $gameModel
     *
     * @return Game
     */
    public static function fromGameModel(Model\Game $gameModel)
    {
        return new self($gameModel->getName());
    }
}
