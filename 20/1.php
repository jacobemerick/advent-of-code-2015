<?php

ini_set('memory_limit', -1);
$goal = 33100000;

$elf = 1;
$presents = 11;
$limit = 2000000;

$houses = array_fill(1, $limit, 0);

for ($elf = 1; $elf <= $limit; $elf++) {
  $delivered = 0;
  for ($i = $elf; $i < $limit; $i += $elf) {
    $delivered++;
    if ($delivered >= 50) {
      break;
    }
    $houses[$i] += $elf * $presents;
    if ($i == $elf && $houses[$i] >= $goal) {
      echo $i, PHP_EOL;
      exit;
    }
  }
}

$house = 1;
foreach ($houses as $h) {
  if ($h == $goal) {
    echo $house, PHP_EOL;
  }
  $house++;
}

