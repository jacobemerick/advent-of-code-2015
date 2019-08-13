<?php

$input = file_get_contents('input');

$length = 1500;
$matrix = array_fill(0, ($length * $length), 0);

$position = ($length / 2) * ($length / 2);
$key = 0;

do {
  $matrix[$position]++;

  $direction = $input[$key];
  if ($direction == '<') {
    $position--;
  } else if ($direction == '>') {
    $position++;
  } else if ($direction == '^') {
    $position -= $length;
  } else if ($direction == 'v') {
    $position += $length;
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
