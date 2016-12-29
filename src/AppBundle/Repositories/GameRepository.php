<?php

namespace AppBundle\Repositories;

use AppBundle\Document\Game;
use AppBundle\Document\Task;
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

    /**
     * @param string $gameId
     * @param string $taskId
     *
     * @return Task
     */
    public function getTask(string $gameId, string $taskId)
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

    /**
     * @param string $gameId
     *
     * @return null|Game
     */
    public function getGame(string $gameId) {
        $qb = $this->createQueryBuilder();

        $query = $qb
            ->field('id')->equals($gameId)
            ->limit(1)
            ->getQuery();
        return $query->getSingleResult();
    }
}
