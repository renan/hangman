<?php

namespace Hangman;

class WordRandomizerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test getting random words until all words are consumed
     *
     */
    public function testNext()
    {
        $words = [
            'one',
            'two',
            'three',
        ];
        $wordRandomizer = new wordRandomizer($words);

        $randomized = [
            $wordRandomizer->next(),
            $wordRandomizer->next(),
            $wordRandomizer->next(),
        ];

        $this->assertCount(3, $randomized, 'Should have 3 words');
        $this->assertEmpty(array_diff($words, $randomized), 'Words and Randomized words differ');
        
        $this->assertNull($wordRandomizer->next(), 'Should not have a 4th word, and return null');
    }
}
