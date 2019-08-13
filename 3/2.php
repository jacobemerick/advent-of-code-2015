<?php

$input = file_get_contents('input');

$length = 1500;
$matrix = array_fill(0, ($length * $length), 0);

$position_a = ($length / 2) * ($length / 2);
$position_b = ($length / 2) * ($length / 2);
$key = 0;

do {
  $matrix[$position_a]++;
  $matrix[$position_b]++;

  $direction = $input[$key];
  if ($direction == '<') {
    $position_a--;
  } else if ($direction == '>') {
    $position_a++;
  } else if ($direction == '^') {
    $position_a -= $length;
  } else if ($direction == 'v') {
    $position_a += $length;
  }

  $key++;

  $direction = $input[$key];
  if ($direction == '<') {
    $position_b--;
  } else if ($direction == '>') {
    $position_b++;
  } else if ($direction == '^') {
    $position_b -= $length;
  } else if ($direction == 'v') {
    $position_b += $length;
  }

  $key++;
} while ($key < strlen($input));

$values = array_count_values($matrix);
$visited = 0;
foreach ($values as $key => $value) {
  if ($key == 0) {
    echo 'Nothing: ', $value, PHP_EOL;
  } else {
    $visited += $value;
  }
}
echo 'Visited: ', $visited, PHP_EOL;
