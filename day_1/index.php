<?php

$file = fopen("input.txt", "r") or die("Unable to open file!");
$total = 0;
while (!feof($file)) {
    $row = fgets($file);
    $numbers = array_values(array_filter(str_split($row), function ($character) {
        return is_numeric($character);
    }));

    if (empty($numbers)) continue;

    $total += count($numbers) === 1
        ? $numbers[0] . $numbers[0]
        : $numbers[0] . end($numbers);
}
echo $total;
fclose($file);
