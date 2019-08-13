<?php

$input = [
  'Sprinkles' => [
    'capacity' => 2,
    'durability' => 0,
    'flavor' => -2,
    'texture' => 0,
    'calories' => 3,
  ],
  'Butterscotch' => [
    'capacity' => 0,
    'durability' => 5,
    'flavor' => -3,
    'texture' => 0,
    'calories' => 3,
  ],
  'Chocolate' => [
    'capacity' => 0,
    'durability' => 0,
    'flavor' => 5,
    'texture' => -1,
    'calories' => 8,
  ],
  'Candy' => [
    'capacity' => 0,
    'durability' => -1,
    'flavor' => 0,
    'texture' => 5,
    'calories' => 8,
  ],
];

$high_score = 0;
for ($a = 0; $a <= 100; $a++) {
  for ($b = 0; $b <= 100; $b++) {
    for ($c = 0; $c <= 100; $c++) {
      for ($d = 0; $d <= 100; $d++) {
        if (($a + $b + $c + $d) != 100) {
          continue;
        }

        $capacity =
          $a * $input['Sprinkles']['capacity'] +
          $b * $input['Butterscotch']['capacity'] +
          $c * $input['Chocolate']['capacity'] +
          $d * $input['Candy']['capacity'];
        $durability =
          $a * $input['Sprinkles']['durability'] +
          $b * $input['Butterscotch']['durability'] +
          $c * $input['Chocolate']['durability'] +
          $d * $input['Candy']['durability'];
        $flavor =
          $a * $input['Sprinkles']['flavor'] +
          $b * $input['Butterscotch']['flavor'] +
          $c * $input['Chocolate']['flavor'] +
          $d * $input['Candy']['flavor'];
        $texture =
          $a * $input['Sprinkles']['texture'] +
          $b * $input['Butterscotch']['texture'] +
          $c * $input['Chocolate']['texture'] +
          $d * $input['Candy']['texture'];

        if (
          $capacity <= 0 ||
          $durability <= 0 ||
          $flavor <= 0 ||
          $texture <= 0
        ) {
          continue;
        }

        $score = $capacity * $durability * $flavor * $texture;
        if ($high_score < $score) {
          $high_score = $score;
        }
      }
    }
  }
}

echo 'Highest score: ', $high_score, PHP_EOL;
