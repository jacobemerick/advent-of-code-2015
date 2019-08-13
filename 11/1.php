<?php

$alphabet = [
  'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
  'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
];

$password = 'hxbxxyzz';
$password = str_split($password);

while (true) {
  for ($i = 7; $i >= 0; $i--) {
    if ($password[$i] == 'z') {
      $password[$i] = 'a';
    }
    else {
      $key = array_search($password[$i], $alphabet);
      $key++;
      $password[$i] = $alphabet[$key];
      break;
    }
  }

  $validity_reqs = 0;

  for ($i = 0; $i <= 4; $i++) {
    $start = array_search($password[$i], $alphabet);
    $length = 1;
    for ($j = 1; $j < 3; $j++) {
      $test = array_search($password[$j + $i], $alphabet);
      if (($test - $start) == $j) {
        $length++;
      }
    }
    if ($length == 3) {
      $validity_reqs++;
      break;
    }
  }

  if (
    !in_array('i', $password) &&
    !in_array('o', $password) &&
    !in_array('l', $password)
  ) {
    $validity_reqs++;
  }

  $test_password = implode('', $password);
  if (preg_match('/([a-z])\1.*([a-z])\2/', $test_password)) {
    $validity_reqs++;
  }

  if ($validity_reqs == 3) {
    break;
  }
};

echo 'New password: ', implode('', $password), PHP_EOL;
