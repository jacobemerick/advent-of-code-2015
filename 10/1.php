<?php

ini_set('memory_limit', -1);
$input = 3113322113;

function lookAndSay($array) {
  $response = [];

  $last_character = '';
  $character_count = 0;

  foreach ($array as $character) {
    if (empty($last_character)) {
      $last_character = $character;
      $character_count++;
      continue;
    }

    if ($character == $last_character) {
      $character_count++;
      continue;
    }

    array_push($response, $character_count, $last_character);
    $last_character = $character;
    $character_count = 1;
  }
  array_push($response, $character_count, $last_character);
  return $response;
}

$array = str_split($input);
for ($i = 0; $i < 50; $i++) {
  $array = lookAndSay($array);
}

echo 'Length of string: ', count($array), PHP_EOL;
