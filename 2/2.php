<?php

$input = fopen('1.input', 'r');

$total_length = 0;
while ($row = fgets($input)) {
  $dimensions = explode('x', $row);
  $dimensions = array_map(function ($value) {
    $value = trim($value);
    $value = (int) $value;
    return $value;
  }, $dimensions);

  $length = $dimensions[0] * $dimensions[1] * $dimensions[2];

  rsort($dimensions);
  array_shift($dimensions);
  $length += 2 * ($dimensions[0] + $dimensions[1]);

  $total_length += $length;
}

fclose($input);

echo 'Total needed: ', $total_length, PHP_EOL;
