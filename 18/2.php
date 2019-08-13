<?php

$input = fopen('input', 'r');
$lights = array();

while ($row = fgets($input)) {
  $row = trim($row);
  $row = str_split($row);
  array_push($lights, $row);
}

$lights[0][0] = '#';
$lights[0][99] = '#';
$lights[99][0] = '#';
$lights[99][99] = '#';

function count_neighbors($lights, $x, $y) {
  $neighbors = 0;
  for ($i = -1; $i <= 1; $i++) {
    for ($j = -1; $j <= 1; $j++) {
      if ($i === 0 && $j === 0) {
        continue;
      }
      if (isset($lights[$x + $i][$y + $j])) {
        if ($lights[$x + $i][$y + $j] == '#') {
          $neighbors++;
        }
      }
    }
  }
  return $neighbors;
}

for($i = 0; $i < 100; $i++) {
  $new_lights = array_fill(0, 100, array_fill(0, 100, ''));
  foreach ($lights as $x => $row) {
    foreach ($row as $y => $col) {
      if (
        ($x == 0 || $x == 99) &&
        ($y == 0 || $y == 99)
      ) {
        $new_lights[$x][$y] = '#';
        continue;
      }
      $neighbors = count_neighbors($lights, $x, $y);
      if ($col == '#') {
        if ($neighbors == 2 || $neighbors == 3) {
          $new_lights[$x][$y] = '#';
        } else {
          $new_lights[$x][$y] = '.';
        }
      } else {
        if ($neighbors == 3) {
          $new_lights[$x][$y] = '#';
        } else {
          $new_lights[$x][$y] = '.';
        }
      }
    }
  }
  $lights = $new_lights;
}

$on_lights = 0;
foreach ($lights as $row) {
  foreach ($row as $col) {
    if ($col == '#') {
      $on_lights++;
    }
  }
}

echo 'Total lights on: ', $on_lights, PHP_EOL;
