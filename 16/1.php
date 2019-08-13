<?php

$input = fopen('input', 'r');

$sue_template = [
  'children' => 3,
  'cats' => 7,
  'samoyeds' => 2,
  'pomeranians' => 3,
  'akitas' => 0,
  'vizslas' => 0,
  'goldfish' => 5,
  'trees' => 3,
  'cars' => 2,
  'perfumes' => 1,
];

$sue_holder = [];
while ($row = fgets($input)) {
  $row = trim($row);
  preg_match('/^Sue (\d+): (.+)$/', $row, $matches);

  $sue_holder[$matches[1]] = [];

  $properties = $matches[2];
  $properties = explode(',', $properties);
  $properties = array_map('trim', $properties);

  foreach ($properties as $property) {
    $values = explode(':', $property);
    $values = array_map('trim', $values);
    $sue_holder[$matches[1]][$values[0]] = $values[1];
  }
}

foreach ($sue_holder as $num => $properties) {
  foreach ($properties as $key => $value) {
    if ($sue_template[$key] != $value) {
      continue 2;
    }
  }
  echo 'Found one: ', $num, PHP_EOL;
}
