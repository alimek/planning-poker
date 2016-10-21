<?php

namespace AppBundle\Repositories;

use AppBundle\Model\Game;
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

    public function getTask($gameId, $taskId)
    {
        $qb = $this->createQueryBuilder();

        $query = $qb
            ->select('tasks.$')
            ->field('tasks')->elemMatch(
                $qb->expr()->field('_id')->equals(new \MongoId($taskId))
            )
            ->field('_id')->equals(new \MongoId($gameId))
            ->getQuery();

        $task = $query->getSingleResult();

        return $task;
    }
}
