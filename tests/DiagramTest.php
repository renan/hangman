<?php

namespace Hangman;

class DiagramTest extends \PHPUnit_Framework_TestCase
{
    public function testDrawEmptyDiagram()
    {
        $diagram = new Diagram();
        $drawing = $diagram->draw(
            'zombi',
            [],
            []
        );

        $expected = <<<ASCII
/-----\
|     |
|
|           _ _ _ _ _
|
|
|           
A
ASCII;

        $this->assertEquals($expected, $drawing);
    }

    public function testDrawOneGoodGuess()
    {
        $diagram = new Diagram();
        $drawing = $diagram->draw(
            'zombi',
            ['m'],
            []
        );

        $expected = <<<ASCII
/-----\
|     |
|
|           _ _ M _ _
|
|
|           
A
ASCII;

        $this->assertEquals($expected, $drawing);
    }

    public function testDrawTwoGoodGuesses()
    {
        $diagram = new Diagram();
        $drawing = $diagram->draw(
            'zombi',
            ['m', 'z'],
            []
        );

        $expected = <<<ASCII
/-----\
|     |
|
|           Z _ M _ _
|
|
|           
A
ASCII;

        $this->assertEquals($expected, $drawing);
    }

    public function testDrawOneBadGuess()
    {
        $diagram = new Diagram();
        $drawing = $diagram->draw(
            'zombi',
            [],
            ['w']
        );

        $expected = <<<ASCII
/-----\
|     |
|     o
|           _ _ _ _ _
|
|
|           W
A
ASCII;

        $this->assertEquals($expected, $drawing);
    }

    public function testDrawTwoBadGuesses()
    {
        $diagram = new Diagram();
        $drawing = $diagram->draw(
            'zombi',
            [],
            ['w', 'a']
        );

        $expected = <<<ASCII
/-----\
|     |
|     o
|    -      _ _ _ _ _
|
|
|           W A
A
ASCII;

        $this->assertEquals($expected, $drawing);
    }
}
