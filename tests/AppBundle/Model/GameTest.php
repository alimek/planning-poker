<?php

namespace Tests\AppBundle\Model;

use AppBundle\Model\Game;
use AppBundle\Document;

class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Game
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new Game();
    }
    /**
     * @test
     */
    public function it_is_instantiable()
    {
        $this->assertInstanceOf(Game::class, $this->sut);
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
     * @dataProvider nameProvider
     * @depends it_is_instantiable
     *
     * @param string $name
     */
    public function it_has_name($name)
    {
        $this->sut->setName($name);
        $this->assertSame($name, $this->sut->getName());
    }

    /**
     * @test
     * @depends it_has_name
     */
    public function it_can_be_converted_to_Document_Game()
    {
        $document = $this->sut->toDocument();

        $this->assertInstanceOf(Document\Game::class, $document);
    }

    /**
     * @test
     * @depends it_can_be_converted_to_Document_Game
     */
    public function it_passes_name_to_Document_Game()
    {
        $this->sut->setName('foo bar');
        $document = $this->sut->toDocument();

        $this->assertSame($this->sut->getName(), $document->getName());
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
}
