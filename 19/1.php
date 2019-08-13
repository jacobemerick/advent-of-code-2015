<?php

$startingPoint = 'ORnPBPMgArCaCaCaSiThCaCaSiThCaCaPBSiRnFArRnFArCaCaSiThCaCaSiThCaCaCaCaCaCaSiRnFYFArSiRnMgArCaSiRnPTiTiBFYPBFArSiRnCaSiRnTiRnFArSiAlArPTiBPTiRnCaSiAlArCaPTiTiBPMgYFArPTiRnFArSiRnCaCaFArRnCaFArCaSiRnSiRnMgArFYCaSiRnMgArCaCaSiThPRnFArPBCaSiRnMgArCaCaSiThCaSiRnTiMgArFArSiThSiThCaCaSiRnMgArCaCaSiRnFArTiBPTiRnCaSiAlArCaPTiRnFArPBPBCaCaSiThCaPBSiThPRnFArSiThCaSiThCaSiThCaPTiBSiRnFYFArCaCaPRnFArPBCaCaPBSiRnTiRnFArCaPRnFArSiRnCaCaCaSiThCaRnCaFArYCaSiRnFArBCaCaCaSiThFArPBFArCaSiRnFArRnCaCaCaFArSiRnFArTiRnPMgArF';
$replacements = [];

$input = fopen('input', 'r');
while ($row = fgets($input)) {
  $row = trim($row);
  $row = explode(' => ', $row);
  array_push($replacements, $row);
}

$newMolecules = [];
foreach ($replacements as list($key, $value)) {
  for ($i = 0; $i < strlen($startingPoint); $i++) {
    if ($key == substr($startingPoint, $i, 1)) {
      array_push($newMolecules, substr_replace($startingPoint, $value, $i, 1));
    }
    if ($key == substr($startingPoint, $i, 2)) {
      array_push($newMolecules, substr_replace($startingPoint, $value, $i, 2));
    }
  }
}

$newMolecules = array_unique($newMolecules);
$replacementCount = count($newMolecules);

echo 'Total replacements: ', $replacementCount, PHP_EOL;
