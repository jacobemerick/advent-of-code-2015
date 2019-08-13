<?php

$nice_strings = 0;
$input = fopen('input', 'r');

while ($row = fgets($input)) {
  $row = trim($row);
  if (
    preg_match('/([a-z]{2}).*\1/', $row) &&
    preg_match('/([a-z])[a-z]\1/', $row)
  ) {
    $nice_strings++;
  }
}

echo 'Nice strings: ', $nice_strings, PHP_EOL;
