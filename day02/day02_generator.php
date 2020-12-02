<?php

function lazyRead() : Generator {
    $file = new SplFileObject("passwords.txt", "r");
    while ($file->valid()) {
        $matches = [];
        preg_match("/^(\d+)-(\d+) ([a-z]): ([a-z]*)$/", $file->current(), $matches);
        $file->next();

        yield array_slice($matches, 1);
    }

    $file = NULL;
}

$correctPartOne = 0;
$correctPartTwo = 0;
foreach (lazyRead() as $line) {
    [$min, $max, $char, $password] = $line;
    
    // Part 1
    $occurences = substr_count($password, $char);
    $correctPartOne += ($occurences >= $min && $occurences <= $max);

    // Part 2
    $correctPartTwo += ($password[$min - 1] === $char) ^ ($password[$max - 1] === $char);
}

echo "Part one valid: {$correctPartOne}" . PHP_EOL;
echo "Part two valid: {$correctPartTwo}" . PHP_EOL;