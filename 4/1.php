<?php

$secret = 'iwrupvqb';

$key = 0;
do {
    $key++;
    $hash = md5($secret . $key);
} while (substr($hash, 0, 5) !== '00000');

echo "Key {$key} produced hash {$hash}", PHP_EOL;
