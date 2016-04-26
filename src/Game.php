<?php

namespace Hangman;

/**
 * Hangman rules implementation
 *
 */
final class Game
{
    const MAX_MISTAKES = 5;

    /**
     * Word to be guessed
     *
     * @var string
     */
    private $word;

    /**
     * All symbols in the word
     *
     * @var string[]
     */
    private $symbols;

    /**
     * Wether the game has finished or not
     *
     * @var boolean
     */
    private $isEnded = false;

    /**
     * Wether the player won or lost
     *
     * @var boolean
     */
    private $playerWon;

    /**
     * Good guesses
     *
     * @var string[]
     */
    private $goodGuesses = [];

    /**
     * Bag guesses
     *
     * @var string[]
     */
    private $badGuesses = [];

    /**
     * Constructor
     *
     * @param string $word Word to be guessed
     */
    public function __construct($word)
    {
        \Assert\that($word)
            ->notEmpty()
            ->string()
            ->minLength(self::MAX_MISTAKES);

        $this->word = strtolower($word);
        $this->symbols = array_unique(str_split($this->word));
    }

    /**
     * Guess the next symbol
     *
     * @param string $symbol
     * @return void
     * @throws \DomainException When game has already ended
     * @throws \DomainException When symbol has already been guessed
     */
    public function guess($symbol)
    {
        \Assert\that($symbol)
            ->notEmpty()
            ->string()
            ->length(1);

        if ($this->isEnded) {
            throw new \DomainException('Game has already ended.');
        }

        $symbol = strtolower($symbol);

        if (in_array($symbol, $this->goodGuesses) || in_array($symbol, $this->badGuesses)) {
            throw new \InvalidArgumentException('This symbol has already been guessed.');
        }

        $isGoodGuess = (in_array($symbol, $this->symbols));

        if (! $isGoodGuess) {
            $this->badGuesses[] = $symbol;

            if (count($this->badGuesses) === self::MAX_MISTAKES) {
                $this->end(false);
            }

            return;
        }

        $this->goodGuesses[] = $symbol;

        if (count($this->goodGuesses) === count($this->symbols)) {
            $this->end(true);
        }
    }

    /**
     * End the game
     *
     * @param boolean $playerWon Wether the player won or lost
     * @return void
     */
    private function end($playerWon)
    {
        $this->isEnded = true;
        $this->playerWon = $playerWon;
    }

    /**
     * Returns the word to be guessed
     *
     * @return string
     */
    public function word()
    {
        return $this->word;
    }

    /**
     * Wether the game has finished or not
     *
     * @return boolean
     */
    public function isEnded()
    {
        return $this->isEnded;
    }

    /**
     * Wether the player won or lost
     *
     * @return boolean
     */
    public function playerWon()
    {
        return $this->playerWon;
    }

    /**
     * Good guesses
     *
     * @return string[]
     */
    public function goodGuesses()
    {
        return $this->goodGuesses;
    }

    /**
     * Bad guesses
     *
     * @return string[]
     */
    public function badGuesses()
    {
        return $this->badGuesses;
    }
}
