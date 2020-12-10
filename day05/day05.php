<?php

class Solution {
    private array $data;

    public function readInput(string $filename) : void {
        $input = file_get_contents(filename: $filename);
        $input = explode(separator: "\n", string: $input);
        $input = array_map(
            callback: static function (string $seat) : int {
                return bindec(str_replace(
                    subject: $seat,
                    search: ["F", "L", "B", "R"],
                    replace: ["0", "0", "1", "1"]
                ));
            },
            array: $input
        );

        $this->data = $input;
    }

    public function getMaxSeatId() : int {
        return max(value: $this->data);
    }

    public function findMissingSeatId() : int {
        $possible = range(start: min($this->data), end: max($this->data));
        $missing = array_diff($possible, $this->data);

        return array_values($missing)[0];
    }
}

$solution = new Solution();
$solution->readInput(filename: "seats.txt");

echo("Max seat ID: {$solution->getMaxSeatId()}");
echo("My seat ID: {$solution->findMissingSeatId()}");
