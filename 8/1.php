<?php

$handle = fopen('input', 'r');
$total_characters = 0;
$memory_characters = 0;

$rows = 0;
while ($row = fgets($handle)) {
  $rows++;
  $characters = str_split($row);
  for($i = 0; $i < count($characters); $i++) {

    if ($characters[$i] == '\\' && $characters[$i+1] == '\\') {
      $total_characters += 2;
      $memory_characters += 1;
      $i += 1;
    } else if ($characters[$i] == '\\' && $characters[$i+1] == '"') {
      $total_characters += 2;
      $memory_characters += 1;
      $i += 1;
    } else if ($characters[$i] == '\\' && $characters[$i+1] == 'x') {
      $total_characters += 4;
      $memory_characters += 1;
      $i += 3;
    } else if ($characters[$i] == '"') {
      $total_characters += 1;
    } else {
      $total_characters += 1;
      $memory_characters += 1;
    }
  }
}
echo 'rows: ', $rows, PHP_EOL;
echo ($total_characters - $memory_characters), PHP_EOL;
