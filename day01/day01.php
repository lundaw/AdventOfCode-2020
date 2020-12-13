<?php

class day01 {
    private array $numbers;

    public function readInput(string $filename) : void {
        $input = file_get_contents(filename: $filename);
        $input = array_map("intval", explode("\n", $input));

        $this->numbers = $input;
    }

    public function getPair(int $sum) : int {
        foreach ($this->numbers as $number) {
            $complement = $sum - $number;
            if (in_array($complement, $this->numbers)) {
                return $complement * $number;
            }
        }
        
        return -1;
    }

    public function getTriplet(int $sum) : int {
        foreach ($this->numbers as $first) {
            foreach ($this->numbers as $second) {
                foreach ($this->numbers as $third) {
                    if ($first + $second + $third === $sum) {
                        return $first * $second * $third;
                    }
                }
            }
        }

        return -1;
    }
}

$solution = new day01();
$solution->readInput(filename: "input.txt");

$p1 = $solution->getPair(sum: 2020);
echo("Part one: {$p1}\n");

$p2 = $solution->getTriplet(sum: 2020);
echo("Part two: {$p2}\n");