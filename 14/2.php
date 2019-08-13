<?php

$input = [
  'Vixen can fly 8 km/s for 8 seconds, but then must rest for 53 seconds.',
  'Blitzen can fly 13 km/s for 4 seconds, but then must rest for 49 seconds.',
  'Rudolph can fly 20 km/s for 7 seconds, but then must rest for 132 seconds.',
  'Cupid can fly 12 km/s for 4 seconds, but then must rest for 43 seconds.',
  'Donner can fly 9 km/s for 5 seconds, but then must rest for 38 seconds.',
  'Dasher can fly 10 km/s for 4 seconds, but then must rest for 37 seconds.',
  'Comet can fly 3 km/s for 37 seconds, but then must rest for 76 seconds.',
  'Prancer can fly 9 km/s for 12 seconds, but then must rest for 97 seconds.',
  'Dancer can fly 37 km/s for 1 seconds, but then must rest for 36 seconds.',
];

$instructions = [];
$reindeer = [];
$points = [];
foreach ($input as $row) {
  preg_match('/^(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds\.$/', $row, $matches);
  array_push($instructions, [
    'reindeer' => $matches[1],
    'speed' => $matches[2],
    'duration' => $matches[3],
    'rest' => $matches[4],
  ]);
  $reindeer[$matches[1]] = 0;
  $points[$matches[1]] = 0;
}

for ($i = 0; $i < 2503; $i++) {
  foreach ($instructions as $instruction) {
    $remainder = $i % ($instruction['duration'] + $instruction['rest']);
    if ($remainder < $instruction['duration']) {
      $reindeer[$instruction['reindeer']] += $instruction['speed'];
    }
  }
  arsort($reindeer);
  $furthest = reset($reindeer);

  foreach ($reindeer as $name => $distance) {
    if ($distance == $furthest) {
      $points[$name]++;
    }
  }

  if (false && $i == 500) {
    var_dump($reindeer);
    var_dump($points); exit;
  }
}

arsort($points);
echo array_sum($points);
echo '<pre>'; var_dump($points); exit;
