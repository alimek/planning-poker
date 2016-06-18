<?php

namespace tests\AppBundle\Model;

use AppBundle\Model\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Task
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new Task();
    }

    /**
     * @test
     */
    public function it_is_instantiable()
    {
        $this->assertInstanceOf(Task::class, $this->sut);
    }

    /**
     * @test
     * @depends it_is_instantiable
     */
    public function it_has_no_name_by_default()
    {
        $this->assertNull($this->sut->getName());
    }

    /**
     * @test
     * @depends it_is_instantiable
     */
    public function it_has_name()
    {
        $this->sut->setName('Task');
        $this->assertSame('Task', $this->sut->getName());
    }

}
