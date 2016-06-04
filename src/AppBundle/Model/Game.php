<?php

namespace AppBundle\Model;

use AppBundle\Document;

class Game
{
    /**
     * @var string
     */
    protected $name;

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
     * @return Document\Game
     */
    public function toDocument()
    {
        return new Document\Game($this->getName());
    }
}
