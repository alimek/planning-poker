<?php

namespace AppBundle\Repositories;

use AppBundle\Document\Game;
use Doctrine\ODM\MongoDB\DocumentRepository;

class GameRepository extends DocumentRepository
{
    /**
     * @param Game $game
     */
    public function save(Game $game)
    {
        $this->getDocumentManager()->persist($game);
        $this->getDocumentManager()->flush();
    }

//    public function getTask($taskId)
//    {
//        $this->createQueryBuilder()
//            ->field('task')
//    }

}
