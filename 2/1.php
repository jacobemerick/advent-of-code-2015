<?php

$input = fopen('1.input', 'r');

$total_area = 0;
while ($row = fgets($input)) {
  unset($area);

  $dimensions = explode('x', $row);
  $dimensions = array_map(function ($value) {
    $value = trim($value);
    $value = (int) $value;
    return $value;
  }, $dimensions);

  echo trim($row), PHP_EOL;
  $area[] = 
    2 * $dimensions[0] * $dimensions[1] +
    2 * $dimensions[0] * $dimensions[2] +
    2 * $dimensions[1] * $dimensions[2];

  rsort($dimensions);
  array_shift($dimensions);
  $area[] = $dimensions[0] * $dimensions[1];

  echo implode(' + ', $area), ' = ', array_sum($area), PHP_EOL;

  $total_area += array_sum($area);
  echo $total_area, PHP_EOL, PHP_EOL;

  if ($total_area > 10000) {
//    break;
  }
}

fclose($input);

echo 'Total needed: ', $total_area, PHP_EOL;
