<?php

$nice_strings = 0;
$input = fopen('input', 'r');

while ($row = fgets($input)) {
  $row = trim($row);
  if (preg_match('/((ab)|(cd)|(pq)|(xy))/', $row)) {
    continue;
  }
  if (
    preg_match('/([a-z])\1/', $row) &&
    preg_match_all('/([aeiou])/', $row) >= 3
  ) {
    $nice_strings++;
  }
}

echo 'Nice strings: ', $nice_strings, PHP_EOL;
