<?php

$input = file_get_contents('input');
$input = json_decode($input, true);

function accountingIsHard($json) {
  $sum = 0;
  foreach ($json as $key => $value) {
    if (is_numeric($value)) {
      $sum += $value;
    } else if (is_array($value)) {
      $sum += accountingIsHard($value);
    }
  }
  return $sum;
}

$sum = accountingIsHard($input);
echo 'Sum: ', $sum, PHP_EOL;

