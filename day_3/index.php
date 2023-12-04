<?php

$file = fopen("input.txt", "r") or die("Unable to open file!");
$numbers = [];
$symbols = [];
$currentNbr = 0;
$currentKey = '';

while (!feof($file)) {
    $index = 1;
    $row = fgets($file);
    if (!$row) continue;

    $currentKey = 'l' . $index . '-';
    foreach (str_split($row) as $key => $character) {
        if (is_numeric($character)) {
            $currentNbr .= $character;
            $currentKey .= $key;
        }
    }
    
}

fclose($file);
