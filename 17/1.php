<?php

$eggnog = 150;
$input = fopen('input', 'r');
$containers = [];

while ($row = fgets($input)) {
  $row = trim($row);
  array_push($containers, $row);
}
rsort($containers);

$count = array();
function fill_bottle($in, $remaining, $size) {
  global $count;
  while (count($in)) {
    $try = array_shift($in);
    if ($try == $remaining) $count[$size]++;
    else if ($try < $remaining) fill_bottle($in, $remaining - $try, $size + 1);
  }
}

fill_bottle($containers, 150, 1);
ksort($count);
echo array_sum($count) . '/' . array_shift($count), PHP_EOL;
