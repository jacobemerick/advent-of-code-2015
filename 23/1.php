<?php

$handle = fopen('input', 'r');
$input = [];
while ($row = fgets($handle)) {
  array_push($input, trim($row));
}

$a = 1;
$b = 0;

for ($i = 0; $i < count($input); $i++) {
  $row = $input[$i];
  $instruction = substr($row, 0, 3);

  if ($instruction == 'jmp') {
    $distance = substr($row, 4);
    $i += ($distance - 1);
    continue;
  }

  $register = substr($row, 4, 1);

  if ($instruction == 'jio') {
    if ($$register == 1) {
      $distance = substr($row, 7);
      $i += ($distance - 1);
    }
    continue;
  }

  if ($instruction == 'jie') {
    if ($$register % 2 == 0) {
      $distance = substr($row, 7);
      $i += ($distance - 1);
    }
    continue;
  }
 
  if ($instruction == 'hlf') {
    $$register /= 2;
  }
  if ($instruction == 'inc') {
    $$register++;
  }
  if ($instruction == 'tpl') {
    $$register *= 3;
  }
}
    
echo $b;
