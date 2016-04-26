<?php

namespace Hangman;

class Diagram
{

    /**
     * Draw the diagram representing the current game state
     *
     * @param string $secret The secret word being guessed
     * @param string[] $goodGuesses
     * @param string[] $badGuesses
     * @return string
     */
    public function draw($secret, array $goodGuesses, array $badGuesses)
    {
        $secret = strtoupper($secret);
        $goodGuesses = array_map('strtoupper', $goodGuesses);
        $badGuesses = array_map('strtoupper', $badGuesses);

        $symbols = str_split($secret);
        
        $partialSecret = [];
        foreach ($symbols as $symbol) {
            if (in_array($symbol, $goodGuesses)) {
                $partialSecret[] = $symbol;
            } else {
                $partialSecret[] = '_';
            }
        }

        return sprintf(
            $this->hangingMan(count($badGuesses)),
            implode(' ', $partialSecret),
            implode(' ', $badGuesses)
        );
    }

    private function hangingMan($bodyParts)
    {
        switch ($bodyParts) {
            case 0:
                return <<<ASCII
/-----\
|     |
|
|           %s
|
|
|           %s
A
ASCII;

            case 1:
                return <<<ASCII
/-----\
|     |
|     o
|           %s
|
|
|           %s
A
ASCII;

            case 2:
                return <<<ASCII
/-----\
|     |
|     o
|    -      %s
|
|
|           %s
A
ASCII;

            case 3:
                return <<<ASCII
/-----\
|     |
|     o
|    \./    %s
|
|
|           %s
A
ASCII;

            case 4:
                return <<<ASCII
/-----\
|     |
|     o
|    \./    %s
|    / 
|
|           %s
A
ASCII;

            case 5:
                return <<<ASCII
/-----\
|     |
|     o
|    \./    %s
|    / \
|
|           %s
A
ASCII;
        }
    }
}
