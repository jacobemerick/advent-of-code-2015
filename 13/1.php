<?php

require_once 'vendor/autoload.php';

$input = fopen('input', 'r');

$people = [];
$happiness = [];
while ($row = fgets($input)) {
  $row = trim($row);
  $parsed_row = preg_match('/^(\w+) would (\w+) (\d+) happiness units by sitting next to (\w+)\.$/', $row, $matches);

  if (!in_array($matches[1], $people)) {
    array_push($people, $matches[1]);
  }

  $change = $matches[3];
  $change *= ($matches[2] == 'gain') ? 1 : -1;

  if (array_key_exists("{$matches[4]}-{$matches[1]}", $happiness)) {
    $happiness["{$matches[4]}-{$matches[1]}"] += $change;
  } else if (array_key_exists("{$matches[1]}-{$matches[4]}", $happiness)) {
    $happiness["{$matches[1]}-{$matches[4]}"] += $change;
  } else {
    $happiness["{$matches[1]}-{$matches[4]}"] = $change;
  }
}

$holder = [];

$iterator = new NajiDev\Permutation\PermutationIterator($people);
foreach ($iterator as $shuffled) {
  if (count($shuffled) != count($people)) {
    continue;
  }

  $total_happiness = 0;
  foreach ($shuffled as $key => $person) {
    if (($key + 1) == count($people)) {
      $next = $shuffled[0];
    } else {
      $next = $shuffled[$key + 1];
    }

    if (array_key_exists("{$person}-{$next}", $happiness)) {
      $total_happiness += $happiness["{$person}-{$next}"];
    } else if (array_key_exists("{$next}-{$person}", $happiness)) {
      $total_happiness += $happiness["{$next}-{$person}"];
    } else {
      exit('could not find happiness');
    }
  }

  $key = implode('-', $shuffled);
  $holder[$key] = $total_happiness;
}

rsort($holder);

echo 'Largest total happiness: ', reset($holder), PHP_EOL;
