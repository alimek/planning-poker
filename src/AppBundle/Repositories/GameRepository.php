<?php

namespace AppBundle\Repositories;

use AppBundle\Document\Game;
use Doctrine\ODM\MongoDB\DocumentRepository;

class GameRepository extends DocumentRepository
{
    public function save(Game $game)
    {
        $this->getDocumentManager()->persist($game);
        $this->getDocumentManager()->flush();
    }
}
