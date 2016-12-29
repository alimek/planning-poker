<?php
namespace AppBundle\Repositories;

use AppBundle\Document\Player;
use Doctrine\ODM\MongoDB\DocumentRepository;

class PlayerRepository extends DocumentRepository
{
    /**
     * @param string $playerGUID
     *
     * @return Player | null
     */
    public function getPlayerByGUID(string $playerGUID)
    {
        return $this->createQueryBuilder()
            ->field('guid')->equals($playerGUID)
            ->limit(1)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param Player $player
     */
    public function save(Player $player)
    {
        $this->getDocumentManager()->persist($player);
        $this->getDocumentManager()->flush();
    }
}