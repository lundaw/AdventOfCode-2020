<?php

function getSeatId(string $seat) : int {
    $row = str_replace(
        subject: substr($seat, 0, 7),
        search: ["F", "B"],
        replace: ["0", "1"],
    );
    $row = bindec($row);

    $column = str_replace(
        subject: substr($seat, 7),
        search: ["L", "R"],
        replace: ["0", "1"],
    );
    $column = bindec($column);

    return ($row * 8) + $column;
}

function findMissingSeatId(array $seats) : int {
    $possible = range(start: 85, end: 890);
    $missing = array_diff($possible, $seats);

    return array_values($missing)[0];
}

$data = explode("\n", file_get_contents("seats.txt"));
$results = [];

foreach ($data as $seat) {
    $results[] = getSeatId($seat);
}

$maxSeatId = max($results);
$missingSeatId = findMissingSeatId($results);
echo("Max seat ID: {$maxSeatId}\nMy seat ID: {$missingSeatId}\n");