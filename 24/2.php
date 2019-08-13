<?php

$handle = fopen('input', 'r');
$input = [];
while ($row = fgets($handle)) {
  array_push($input, trim($row));
}
rsort($input);

$sum = array_sum($input);
echo "Total weight: ", $sum, PHP_EOL;
echo "Expected group weight: ", ($sum / 4), PHP_EOL;

require_once 'Combinations.php';

for ($i = 0; $i < count($input); $i++) {
  $groups = [];
  $found_small_group = false;
  $combinations = new Combinations($input, $i);
  foreach ($combinations as $combination) {
    if (array_sum($combination) == ($sum / 4)) {
      $found_small_group = true;
      array_push($groups, $combination);
    }
  }
  if ($found_small_group) {
    break;
  }
}

echo 'Found ', count($groups), ' small groups', PHP_EOL;

$smallest_qe = 0;
$best_group = [];
foreach ($groups as $group) {
  $qe = array_product($group);
  if ($smallest_qe === 0 || $qe < $smallest_qe) {
    $smallest_qe = $qe;
    $best_group = $group;
  }
}

echo 'Smallest QE: ', $smallest_qe, PHP_EOL;

echo PHP_EOL;
