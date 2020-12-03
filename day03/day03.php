<?php

$data = explode("\n", file_get_contents("map.txt"));
$x = $trees = [0, 0, 0, 0, 0];
$y_r1d2 = 0;

for ($i = 1; $i < count($data); $i++) {
    // R1D1, R3D1, R5D1, R7D1
    for ($idx = 0, $offset = 1; $idx < 4; $idx++, $offset += 2) {
        $x[$idx] = ($x[$idx] + $offset) % 31;
        $trees[$idx] += $data[$i][$x[$idx]] == '#';
    }

    // R1D2
    $x[4] = ($x[4] + 1) % 31;
    $y_r1d2 += 2;
    $next = $data[$y_r1d2] ?? null;
    $trees[4] += ($next ? $next[$x[4]] == '#' : 0);
}

echo(sprintf("R1D1: %d, R3D1: %d, R5D1: %d, R7D1: %d, R1D2: %d\n", ...$trees));
$product = $trees[0] * $trees[1] * $trees[2] * $trees[3] * $trees[4];
echo("Product is $product" . PHP_EOL);