<?php

// Code is written and run on 64-bit system where the PHP_INT_MAX
// can hold the value of the largest value in the input.

function readInput(string $filename) : array {
    $data = file_get_contents(filename: $filename);
    $data = explode(separator: "\n", string: $data);

    foreach ($data as &$value) {
        $value = (int) $value;
    }

    return $data;
}

function partOne(array $data) : int {
    $possibilities = array_slice(array: $data, offset: 0, length: 25);
    
    for ($i = 25; $i < count($data); $i++) {
        // Looking for combinations between the possibilites
        for ($first = 0; $first < count($possibilities) - 1; $first++) {
            for ($second = $first + 1; $second < count($possibilities); $second++) {
                if ($possibilities[$first] + $possibilities[$second] === $data[$i]) {
                    array_shift(array: $possibilities);
                    array_push($possibilities, $data[$i]);

                    continue 3;
                }
            }
        }

        // The only way to get here if there is no combination and the
        // nested for loops finish without finding a match (calling continue 3;)
        return $data[$i];
    }
}

function recursive(array $input, int $required, int $depth, int $idx, int $sum) : int|bool {
    if ($idx === count($input) || $input[$idx] + $sum > $required || $depth >= 50) {
        return false;
    }

    if ($input[$idx] + $sum === $required) {
        return $input[$idx];
    }

    return recursive($input, $required, $depth + 1, $idx + 1, $sum + $input[$idx]);
}

function partTwo(array $data, int $requiredSum) : int {
    $idxOfSum = array_search(needle: $requiredSum, haystack: $data, strict: true);
    $subset = array_slice(array: $data, offset: 0, length: $idxOfSum);

    for ($currentIdx = 0; $currentIdx < count($subset); $currentIdx++) {
        $currentSum = $subset[$currentIdx];
        $valuesInCurrentSum = [$currentSum];

        for ($lastIndex = $currentIdx + 1; $currentSum <= $requiredSum && $lastIndex < count($subset); $lastIndex++) {
            if ($currentSum === $requiredSum && count($valuesInCurrentSum) >= 2) {
                return min($valuesInCurrentSum) + max($valuesInCurrentSum);
            }

            $currentSum += $subset[$lastIndex];
            $valuesInCurrentSum[] = $subset[$lastIndex];
        }
    }

    return -1;
}

$input = readInput(filename: "input.txt");
$erroneousNumber = partOne(data: $input);
echo("Error detected for number {$erroneousNumber}.\n");

$sum = partTwo(data: $input, requiredSum: $erroneousNumber);
echo("Sum: {$sum}\n");