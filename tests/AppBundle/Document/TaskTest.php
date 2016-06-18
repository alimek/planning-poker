<?php

namespace tests\AppBundle\Document;

use AppBundle\Document\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_instantiable()
    {
        $sut = new Task('foo bar');
        $this->assertInstanceOf(Task::class, $sut);
    }

    /**
     * @test
     * @dataProvider nameProvider
     * @depends it_is_instantiable
     *
     * @param string $name
     */
    public function it_has_name($name)
    {
        $sut = new Task($name);
        $this->assertSame($name, $sut->getName());
    }

    /**
     * @return array
     */
    public function nameProvider()
    {
        return [
            [ 'test name' ],
            [ 'foo' ],
            [ 'bar' ],
            [ 'foo bar' ],
        ];
    }

    /**
     * @test
     */
    public function it_can_be_created_from_model()
    {
        $model = new \AppBundle\Model\Task();
        $model->setName('Task');
        $sut = Task::fromModel($model);
        $this->assertInstanceOf(Task::class, $sut);
    }

    /**
     * @test
     */
    public function it_passes_name_from_model_to_task()
    {
        $model = new \AppBundle\Model\Task();
        $model->setName('Task');
        $sut = Task::fromModel($model);
        $this->assertSame($model->getName(), $sut->getName());
    }
}
