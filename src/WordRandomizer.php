<?php

namespace Hangman;

/**
 * A container of random words
 *
 */
class WordRandomizer
{

    /**
     * Randomized words
     *
     * @var string[]
     */
    private $words;

    /**
     * Constructor
     *
     * @param string[] $words Words to be randomized
     */
    public function __construct(array $words)
    {
        shuffle($words);

        $this->words = $words;
    }

    /**
     * Returns the next word or null when there are no more words
     *
     * @return null|string
     */
    public function next()
    {
        return array_shift($this->words);
    }
}
