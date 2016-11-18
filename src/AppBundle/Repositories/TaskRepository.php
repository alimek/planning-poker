<?php
namespace AppBundle\Repositories;

use AppBundle\Document\Task;
use Doctrine\ODM\MongoDB\DocumentRepository;

class TaskRepository extends DocumentRepository
{
    /**
     * @param Task $task
     */
    public function save(Task $task)
    {
        $this->getDocumentManager()->persist($task);
        $this->getDocumentManager()->flush();
    }
}
