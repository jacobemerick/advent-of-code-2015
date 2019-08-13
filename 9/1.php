<?php

require_once 'vendor/autoload.php';

$input = fopen('input', 'r');

$destinations = [];
$distances = [];
while ($row = fgets($input)) {
  $row = trim($row);
  $parsed_row = preg_match('/^((\w+) to (\w+)) = (\d+)$/', $row, $matches);
  array_shift($matches);

  if (!in_array($matches[1], $destinations)) {
    array_push($destinations, $matches[1]);
  }
  if (!in_array($matches[2], $destinations)) {
    array_push($destinations, $matches[2]);
  }

  $distances[$matches[0]] = $matches[3];
}

$holder = [];

$iterator = new NajiDev\Permutation\PermutationIterator($destinations);
foreach ($iterator as $shuffled) {
  if (count($shuffled) != count($destinations)) {
    continue;
  }

  $length = 0;
  for ($i = 1; $i < count($shuffled); $i++) {
    $key_a = "{$shuffled[$i - 1]} to {$shuffled[$i]}";
    $key_b = "{$shuffled[$i]} to {$shuffled[$i - 1]}";

    if (array_key_exists($key_a, $distances)) {
      $length += $distances[$key_a];
    } else if (array_key_exists($key_b, $distances)) {
      $length += $distances[$key_b];
    } else {
      break 2;
    }
  }

  $key = implode(' to ', $shuffled);
  $holder[$key] = $length;
}

asort($holder);
echo 'shortest distance: ', reset($holder), PHP_EOL;
echo 'longest distance: ', end($holder), PHP_EOL;
