<?php

ini_set('memory_limit', -1);

$startingPoint = 'e';
$goalMolecule = 'ORnPBPMgArCaCaCaSiThCaCaSiThCaCaPBSiRnFArRnFArCaCaSiThCaCaSiThCaCaCaCaCaCaSiRnFYFArSiRnMgArCaSiRnPTiTiBFYPBFArSiRnCaSiRnTiRnFArSiAlArPTiBPTiRnCaSiAlArCaPTiTiBPMgYFArPTiRnFArSiRnCaCaFArRnCaFArCaSiRnSiRnMgArFYCaSiRnMgArCaCaSiThPRnFArPBCaSiRnMgArCaCaSiThCaSiRnTiMgArFArSiThSiThCaCaSiRnMgArCaCaSiRnFArTiBPTiRnCaSiAlArCaPTiRnFArPBPBCaCaSiThCaPBSiThPRnFArSiThCaSiThCaSiThCaPTiBSiRnFYFArCaCaPRnFArPBCaCaPBSiRnTiRnFArCaPRnFArSiRnCaCaCaSiThCaRnCaFArYCaSiRnFArBCaCaCaSiThFArPBFArCaSiRnFArRnCaCaCaFArSiRnFArTiRnPMgArF';
$replacements = [];

$input = fopen('input', 'r');
while ($row = fgets($input)) {
  $row = trim($row);
  $row = explode(' => ', $row);
  array_push($replacements, $row);
}

$target = $goalMolecule;
while ($target != 'e') {
    $length = strlen($target);
    foreach ($replacements as $r) {
        if (($pos = strpos($target, $r[1])) !== false AND @++$z) {
            $target = substr_replace($target, $r[0], $pos, strlen($r[1]));
        }
    }
    if ($length == strlen($target)) {
      echo 'got down to ', strlen($target), ', going to shuffle', PHP_EOL;
      shuffle($replacements);
      $z = 0;
      $target = $goalMolecule;
    }
}

echo $z;
