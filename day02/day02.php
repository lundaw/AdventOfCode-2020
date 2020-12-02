<?php

$data = explode("\n", file_get_contents("./passwords.txt"));
$correctPartOne = 0;
$correctPartTwo = 0;

foreach ($data as $line) {
    $matches = [];
    preg_match("/^(\d+)-(\d+) ([a-z]): ([a-z]*)$/", $line, $matches);
    [, $min, $max, $char, $password] = $matches;
    
    // Part 1
    $occurences = substr_count($password, $char);
    $correctPartOne += ($occurences >= $min && $occurences <= $max);

    // Part 2
    $correctPartTwo += ($password[$min - 1] === $char) ^ ($password[$max - 1] === $char);
}

echo "Part one valid: {$correctPartOne}" . PHP_EOL;
echo "Part two valid: {$correctPartTwo}" . PHP_EOL;