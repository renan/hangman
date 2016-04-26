<?php

namespace Hangman;

class GameTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test winning the game
     *
     */
    public function testWinGame()
    {
        $game = new Game('zombi');
        $game->guess('z');
        $game->guess('o');
        $game->guess('m');
        $game->guess('b');
        $game->guess('i');

        $this->assertTrue($game->isEnded());
        $this->assertTrue($game->playerWon());
    }

    /**
     * Test losing the game
     *
     */
    public function testLoseGame()
    {
        $game = new Game('walker');
        $game->guess('z');
        $game->guess('o');
        $game->guess('m');
        $game->guess('b');
        $game->guess('i');

        $this->assertTrue($game->isEnded());
        $this->assertFalse($game->playerWon());
    }

    /**
     * Test trying to play on ended game
     *
     */
    public function testCantPlayOnEndedGame()
    {
        $game = new Game('zombi');
        $game->guess('z');
        $game->guess('o');
        $game->guess('m');
        $game->guess('b');
        $game->guess('i');

        try {
            $game->guess('s');
            $this->fail('Allowed to play even when game ended');
        } catch (\DomainException $exception) {
            // no-op
        }
    }
}
