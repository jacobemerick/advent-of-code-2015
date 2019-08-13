<?php

$handle = fopen('input', 'r');
$values = [];
$circuits = [];

while ($row = fgets($handle)) {
  $row = trim($row);

  if (preg_match('/^(\d+) -> (\w+)$/', $row, $matches)) {
    $values[$matches[2]] = $matches[1];
    continue;
  }

  if (preg_match('/^(\w+) AND (\w+) -> (\w+)$/', $row, $matches)) {
    if (is_numeric($matches[1])) {
      $circuit = [
        'params' => [$matches[2]],
        'logic' => "{$matches[1]} & \${$matches[2]}",
        'output' => $matches[3]
      ];
    } elseif (is_numeric($matches[2])) {
      $circuit = [
        'params' => [$matches[1]],
        'logic' => "\${$matches[1]} & {$matches[2]}",
        'output' => $matches[3]
      ];
    } else {
      $circuit = [
        'params' => [$matches[1], $matches[2]],
        'logic' => "\${$matches[1]} & \${$matches[2]}",
        'output' => $matches[3]
      ];
    }
  }

  if (preg_match('/^(\w+) OR (\w+) -> (\w+)$/', $row, $matches)) {
    if (is_numeric($matches[1])) {
      $circuit = [
        'params' => [$matches[2]],
        'logic' => "{$matches[1]} | \${$matches[2]}",
        'output' => $matches[3]
      ];
    } elseif (is_numeric($matches[2])) {
      $circuit = [
        'params' => [$matches[1]],
        'logic' => "\${$matches[1]} | {$matches[2]}",
        'output' => $matches[3]
      ];
    } else {
      $circuit = [
        'params' => [$matches[1], $matches[2]],
        'logic' => "\${$matches[1]} | \${$matches[2]}",
        'output' => $matches[3]
      ];
    }
  }

  if (preg_match('/^(\w+) LSHIFT (\d+) -> (\w+)$/', $row, $matches)) {
    $circuit = [
      'params' => [$matches[1]],
      'logic' => "\${$matches[1]} << {$matches[2]}",
      'output' => $matches[3]
    ];
  }

  if (preg_match('/^(\w+) RSHIFT (\d+) -> (\w+)$/', $row, $matches)) {
    $circuit = [
      'params' => [$matches[1]],
      'logic' => "\${$matches[1]} >> {$matches[2]}",
      'output' => $matches[3]
    ];
  }

  if (preg_match('/^NOT (\w+) -> (\w+)$/', $row, $matches)) {
    $circuit = [
      'params' => [$matches[1]],
      'logic' => "~ \${$matches[1]}",
      'output' => $matches[2]
    ];
  }

  if (preg_match('/^(\w+) -> (\w)$/', $row, $matches)) {
    $circuit = [
      'params' => [$matches[1]],
      'logic' => "\${$matches[1]}",
      'output' => $matches[2]
    ];
  }

  array_push($circuits, $circuit);
}

$execute_logic = function ($logic, $values) {
  extract ($values);
  eval("\$output = {$logic};");
  return $output;
};
  
$parse_circuits = function (&$circuits) use (&$values, $execute_logic) {
  foreach ($circuits as $key => $circuit) {
    if (empty(array_diff($circuit['params'], array_keys($values)))) {
      $output = $execute_logic($circuit['logic'], $values);
      $values[$circuit['output']] = $output;
      unset($circuits[$key]);
    }
  }
};

$last_run = count($circuits);
do {
  $parse_circuits($circuits);

  if ($last_run == count($circuits)) {
    echo 'not parsing any more';
    var_dump($values);
    var_dump($circuits);
    break;
  }
  $last_run = count($circuits);
} while (!empty($circuits));

echo $values['a'], PHP_EOL;
