<?php

namespace tests\AppBundle\Util\Service;

use AppBundle\Document\Task;
use AppBundle\Document\Vote;
use AppBundle\Util\Service\ResultsService;
use AppBundle\Util\Strategy\PlanningPokerVoteStrategy;

class ResultsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_average()
    {
        $task = $this->prophesize(Task::class);

        $vote1 = $this->prophesize(Vote::class);
        $vote1->getValue()->willReturn(100);

        $vote2 = $this->prophesize(Vote::class);
        $vote2->getValue()->willReturn(200);

        $vote3 = $this->prophesize(Vote::class);
        $vote3->getValue()->willReturn(800);

        $task->getVotes()->willReturn([
            $vote1->reveal(),
            $vote2->reveal(),
            $vote3->reveal(),
        ]);

        $strategy = new PlanningPokerVoteStrategy();

        $sut = new ResultsService();

        $this->assertEquals('5', $sut->getResult($task->reveal(), $strategy));
    }
}
