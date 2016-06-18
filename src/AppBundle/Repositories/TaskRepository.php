<?php

namespace AppBundle\Repositories;

use AppBundle\Document\Task;
use Doctrine\ODM\MongoDB\DocumentRepository;

class TaskRepository extends DocumentRepository
{
    public function save(Task $game)
    {
        $this->getDocumentManager()->persist($game);
        $this->getDocumentManager()->flush();
    }
}
