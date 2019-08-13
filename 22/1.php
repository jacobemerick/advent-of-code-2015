<?php

ini_set('memory_limit', -1);

$boss_stats = [
  'hit_points' => 58,
  'damage' => 9,
  'armor' => 0,
];

$user_stats = [
  'hit_points' => 50,
  'damage' => 0,
  'armor' => 0,
];

$startingMana = 500;

$spells = [
  'missle' => [
    'cost' => 53,
    'damage' => 4,
  ],
  'drain' => [
    'cost' => 73,
    'damage' => 2,
    'heals' => 2,
  ],
  'shield' => [
    'cost' => 113,
    'is_delayed' => true,
    'turns' => 6,
    'armor' => 7,
  ],
  'poison' => [
    'cost' => 173,
    'is_delayed' => true,
    'turns' => 6,
    'damage' => 3,
  ],
  'recharge' => [
    'cost' => 229,
    'is_delayed' => true,
    'turns' => 5,
    'mana' => 101,
  ],
];

$paths = [
  [
    'user' => $user_stats,
    'boss' => $boss_stats,
    'manaBalance' => $startingMana,
    'manaSpent' => 0,
    'spells' => [],
  ]
];
$results = [];
$is_user_turn = true;

do {
  if ($is_user_turn) {
    foreach ($paths as $key => $path) {
      $found_a_way_forward = false;
      foreach ($spells as $spell) {
        if (!array_reduce($path['spells'], function ($carry, $item) use ($spell) {
          if ($item['turns'] > 1 && $item['cost'] == $spell['cost']) {
            return false;
          }
          return $carry;
        }, true)) {
          continue;
        }
        if ($path['manaBalance'] > $spell['cost']) {
          $found_a_way_forward = true;
          $new_path = $path;
          array_push($new_path['spells'], $spell);
          $new_path['manaBalance'] -= $spell['cost'];
          $new_path['manaSpent'] += $spell['cost'];
          array_push($paths, $new_path);
        }
      }

      if (!$found_a_way_forward) {
        array_push($results, [
          'winner' => 'boss',
          'mana_used' => $path['manaSpent'],
        ]);
      }
      unset($paths[$key]);
    }
  }

  foreach ($paths as $key => $path) {
    $battle_user_stats = $path['user'];
    $battle_boss_stats = $path['boss'];

    foreach ($path['spells'] as $spell_key => $spell) {
      if (isset($spell['is_delayed'])) {
        unset($paths[$key]['spells'][$spell_key]['is_delayed']);
        continue;
      }

      if (isset($spell['damage'])) {
        $battle_user_stats['damage'] += $spell['damage'];
      }
      if (isset($spell['heals'])) {
        $paths[$key]['user']['hit_points'] += $spell['heals'];
      }
      if (isset($spell['armor'])) {
        $battle_user_stats['armor'] += $spell['armor'];
      }
      if (isset($spell['mana'])) {
        $paths[$key]['manaBalance'] += $spell['mana'];
      }

      if (!isset($spell['turns'])) {
        unset($paths[$key]['spells'][$spell_key]);
      } else if ($spell['turns'] == 1) {
        unset($paths[$key]['spells'][$spell_key]);
      } else {
        $paths[$key]['spells'][$spell_key]['turns']--;
      }
    }
    if (!$is_user_turn) {
      $damage_taken = $battle_boss_stats['damage'] - $battle_user_stats['armor'];
      $damage_taken = max($damage_taken, 1);
      $paths[$key]['user']['hit_points'] -= $damage_taken;
    }

    $damage_taken = $battle_user_stats['damage'];
    $paths[$key]['boss']['hit_points'] -= $damage_taken;
  }

  foreach ($paths as $key => $path) {
    if (
      $path['user']['hit_points'] <= 0 ||
      $path['boss']['hit_points'] <= 0
    ) {
      array_push($results, [
        'winner' => ($path['boss']['hit_points'] <= 0) ? 'user' : 'boss',
        'mana_used' => $path['manaSpent'],
      ]);
      unset($paths[$key]);
    }
  }
  $is_user_turn = !$is_user_turn;
} while (count($paths) > 0 && count($results) < 8000);

$userWon = array_filter($results, function ($item) {
  return $item['winner'] == 'user';
});

usort($userWon, function ($a, $b) {
  return $a['mana_used'] - $b['mana_used'];
});

var_dump($userWon);
