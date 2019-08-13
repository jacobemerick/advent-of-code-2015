<?php

ini_set('memory_limit', -1);

$matrix = array_fill(0, 1000, array_fill(0, 1000, 0));
$instructions = fopen('input', 'r');

$turn_on = function ($value) {
  return 1;
};

$turn_off = function ($value) {
  return 0;
};

$toggle = function ($value) {
  return ($value) ? 0 : 1;
};

while ($row = fgets($instructions)) {
  $row = trim($row);
  preg_match(
    '/^((?:turn on)|(?:turn off)|(?:toggle)) (\d+),(\d+) through (\d+),(\d+)$/',
    $row,
    $parsed_row
  );

  for ($x = $parsed_row[2]; $x <= $parsed_row[4]; $x++) {
    for ($y = $parsed_row[3]; $y <= $parsed_row[5]; $y++) {
      if ($parsed_row[1] == 'turn on') {
        $matrix[$x][$y] = 1;
      }
      if ($parsed_row[1] == 'turn off') {
        $matrix[$x][$y] = 0;
      }
      if ($parsed_row[1] == 'toggle') {
        $matrix[$x][$y] = (int) (!$matrix[$x][$y]);
      }
    }
  }
}

$left_on = 0;
foreach ($matrix as $x) {
  $values = array_count_values($x);
  $left_on += $values[1];
}

echo 'Left on: ', $left_on, PHP_EOL;
