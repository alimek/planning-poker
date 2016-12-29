<?php
namespace AppBundle\Util\Service;

use AppBundle\Document\Task;

class ResultsService
{
    public function getTaskResult(Task $task) {
        $task->getVotes();
    }
}