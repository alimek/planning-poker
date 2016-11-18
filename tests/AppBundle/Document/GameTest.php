<?php

namespace Tests\AppBundle\Document;

use AppBundle\Document\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_instantiable()
    {
        $sut = new Game('foo bar');
        $this->assertInstanceOf(Game::class, $sut);
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
        $sut = new Game($name);
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
     * @depends it_is_instantiable
     */
    public function it_has_status_new()
    {
        $sut = new Game('aaa');
        $this->assertSame(Game::STATUS_NEW, $sut->getStatus());
    }

    /**
     * @test
     * @depends it_is_instantiable
     */
    public function it_can_be_started() {
        $sut = new Game('test');
        $sut->startGame();
        $this->assertSame(Game::STATUS_STARTED, $sut->getStatus());
    }
}
