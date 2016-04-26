<?php

namespace Hangman;

use League\CLImate\CLImate;

/**
 * Implements the Hangman game in a Command Line Interface
 *
 */
class Console
{

    /**
     * Diagram drawer instance
     *
     * @var Diagram
     */
    private $diagram;

    /**
     * Word Randomizer instance
     *
     * @var WordRandomizer
     */
    private $wordRandomizer;

    /**
     * CLImate instance
     *
     * @var CLImate
     */
    private $climate;

    /**
     * Constructor
     *
     * @param Diagram $diagram
     * @param WordRandomizer $wordRandomizer
     * @param CLImate $climate
     */
    public function __construct(Diagram $diagram, WordRandomizer $wordRandomizer, CLImate $climate)
    {
        $this->diagram = $diagram;
        $this->wordRandomizer = $wordRandomizer;
        $this->climate = $climate;
    }

    /**
     * Enter the game loop until user decides not to play anymore
     *
     * @return void
     */
    public function run()
    {
        while (($word = $this->wordRandomizer->next()) !== null) {
            $game = new Game($word);
            
            $this->playGame($game);

            if ($game->playerWon()) {
                $this->climate->out('<green>Congratulations, you win!</green>');
            } else {
                $this->climate->out('<red>You lost!</red>');
            }

            $playAgain = $this->climate
                ->input('Do you wish to play again?')
                ->accept([
                    'y',
                    'n',
                ], true)
                ->prompt();

            if ($playAgain !== 'y') {
                break;
            }
        }

        $this->climate->out('Thank you for playing!');
    }

    /**
     * Enter a single game loop, playing until either the player wins or loses
     *
     * @param Game $game
     */
    private function playGame(Game $game)
    {
        while (! $game->isEnded()) {
            $this->drawGame($game);
            $this->promptValidGuess($game);
            $this->drawGame($game);
        }
    }

    /**
     * Draw the game diagram
     *
     * @param Game $game
     */
    private function drawGame(Game $game)
    {
        $drawing = $this->diagram->draw(
            $game->word(),
            $game->goodGuesses(),
            $game->badGuesses()
        );

        $this->climate->clear();
        $this->climate->out($drawing);
        $this->climate->br();
    }

    /**
     * Prompts the player until a valid guess is provided
     *
     * @param Game $game
     */
    private function promptValidGuess(Game $game)
    {
        while (true) {
            $guess = $this->climate
                ->input('What will be your next guess?')
                ->prompt();

            try {
                $game->guess($guess);
                
                return;
            } catch (\Exception $exception) {
                $this->climate->out('<red>Error!</red> ' . $exception->getMessage());
            }
        }
    }
}
