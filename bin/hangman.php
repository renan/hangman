<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$console = new \Hangman\Console(
    new \Hangman\Diagram(),
    new \Hangman\WordRandomizer([
        '3dhubs',
        'marvin',
        'print',
        'filament',
        'order',
        'layer',
    ]),
    new \League\CLImate\CLImate()
);

return $console->run();
