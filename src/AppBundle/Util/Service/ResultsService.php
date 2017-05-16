<?php

namespace AppBundle\Util\Service;

use AppBundle\Document\Task;
use AppBundle\Document\Vote;
use AppBundle\Util\Strategy\VoteStrategyInterface;

class ResultsService
{
    protected function getArithmeticalAverage(Task $task): int
    {
        $votes = $task->getVotes();

        array_filter(
            $votes,
            function (Vote $vote) {
                return $vote->getValue() !== -1;
            }
        );

        $votes = array_map(
            function (Vote $value) {
                return $value->getValue();
            },
            $votes
        );

        $sum = array_sum($votes);

        return round($sum/count($votes));
    }

    public function getResult(Task $task, VoteStrategyInterface $voteStrategy): int
    {
        $arithmeticalAvg = $this->getArithmeticalAverage($task);
        $i = 0;

        $values = $voteStrategy->getValues();

        while ($values[$i]<$arithmeticalAvg) {
            $i++;
        }

        return $voteStrategy->mapToCard($values[$i]);
    }
}