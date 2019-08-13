<?php

$secret = 'iwrupvqb';

$key = 0;
do {
    $key++;
    $hash = md5($secret . $key);

    if ($key % 1000000 === 0) {
        echo "On key {$key}", PHP_EOL;
    }
} while (substr($hash, 0, 6) !== '000000');

echo "Key {$key} produced hash {$hash}", PHP_EOL;
