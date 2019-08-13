<?php

require_once 'vendor/autoload.php';

$boss_stats = [
  'hit_points' => 104,
  'damage' => 8,
  'armor' => 1,
];

$user_stats = [
  'hit_points' => 100,
  'damage' => 0,
  'armor' => 0,
];

$weapons = [
  'dagger' => [
    'cost' => 8,
    'damage' => 4,
    'armor' => 0,
  ],
  'shortsword' => [
    'cost' => 10,
    'damage' => 5,
    'armor' => 0,
  ],
  'warhammer' => [
    'cost' => 25,
    'damage' => 6,
    'armor' => 0,
  ],
  'longsword' => [
    'cost' => 40,
    'damage' => 7,
    'armor' => 0,
  ],
  'greataxe' => [
    'cost' => 74,
    'damage' => 8,
    'armor' => 0,
  ],
];

$armors = [
  'leather' => [
    'cost' => 13,
    'damage' => 0,
    'armor' => 1,
  ],
  'chainmail' => [
    'cost' => 31,
    'damage' => 0,
    'armor' => 2,
  ],
  'splintmail' => [
    'cost' => 53,
    'damage' => 0,
    'armor' => 3,
  ],
  'bandedmail' => [
    'cost' => 75,
    'damage' => 0,
    'armor' => 4,
  ],
  'platemail' => [
    'cost' => 102,
    'damage' => 0,
    'armor' => 5,
  ],
];

$rings = [
  'damage_1' => [
    'cost' => 25,
    'damage' => 1,
    'armor' => 0,
  ],
  'damage_2' => [
    'cost' => 50,
    'damage' => 2,
    'armor' => 0,
  ],
  'damage_3' => [
    'cost' => 100,
    'damage' => 3,
    'armor' => 0,
  ],
  'defense_1' => [
    'cost' => 20,
    'damage' => 0,
    'armor' => 1,
  ],
  'defense_2' => [
    'cost' => 40,
    'damage' => 0,
    'armor' => 2,
  ],
  'defense_3' => [
    'cost' => 80,
    'damage' => 0,
    'armor' => 3,
  ],
];

function calculate_user_stats($user_stats, $weapon, $armor, $rings) {
  $modifiers = $rings;
  $modifiers[] = $weapon;
  $modifiers[] = $armor;

  return [
    'hit_points' => $user_stats['hit_points'],
    'damage' => array_sum(array_column($modifiers, 'damage')),
    'armor' => array_sum(array_column($modifiers, 'armor')),
  ];
}

function battle($user_stats, $boss_stats) {
  $user_turn = true;
  do {
    if ($user_turn) {
      $damage = ($user_stats['damage'] - $boss_stats['armor']);
      if ($damage < 1) {
        $damage = 1;
      }
      $boss_stats['hit_points'] -= $damage;
    } else {
      $damage = ($boss_stats['damage'] - $user_stats['armor']);
      if ($damage < 1) {
        $damage = 1;
      }
      $user_stats['hit_points'] -= $damage;
    }
    $user_turn = !$user_turn;
  } while ($user_stats['hit_points'] > 0 && $boss_stats['hit_points'] > 0);

  return $user_stats['hit_points'] > 0;
}

$sellable_weapons = array_values($weapons);
$sellable_armors = array_merge(array(), array_values($armors));

$sellable_rings = array(array());
foreach ($rings as $ring) {
  array_push($sellable_rings, array($ring));
}
foreach ($rings as $a) {
  foreach ($rings as $b) {
    array_push($sellable_rings, array($a, $b));
  }
}

$minimum_cost = 0;
foreach ($sellable_weapons as $weapon) {
  foreach ($sellable_armors as $armor) {
    foreach ($sellable_rings as $rings) {
      $cost = 0;
      $cost += $weapon['cost'];
      if (!empty($armor)) {
        $cost += $armor['cost'];
      }
      if (!empty($rings)) {
        $cost += array_sum(array_column($rings, 'cost'));
      }
      $modified_user_stats = calculate_user_stats($user_stats, $weapon, $armor, $rings);
      $user_won = battle($modified_user_stats, $boss_stats);
      if (!$user_won) {
        continue;
      }
      if ($minimum_cost == 0 || $cost < $minimum_cost) {
        $minimum_cost = $cost;
      }
    }
  }
}

echo 'Minimum cost: ', $minimum_cost, PHP_EOL;
