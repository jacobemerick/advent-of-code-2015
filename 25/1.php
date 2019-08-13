<?php

$desired_position = [2947, 3029];

$position = [1, 1];
$start = 1;

while ($desired_position != $position) {
  $start++;
  if ($position[0] == 1) {
    $position = [($position[1] + 1), 1];
  } else {
    $position = [($position[0] - 1), ($position[1] + 1)];
  }
}

echo "Code position: ", $start, PHP_EOL;

$code = 20151125;
$multiplier = 252533;
$divisor = 33554393;
for ($i = 2; $i <= $start; $i++) {
  $code *= $multiplier;
  $code %= $divisor;
}

echo $code, PHP_EOL;
