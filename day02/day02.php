<?php

class day02 {
    private array $passwords;

    public function __construct(string $filename)
    {
        $input = file_get_contents(filename: $filename);
        $this->passwords = explode(separator: "\n", string: $input);
    }

    public function getSolution() : array
    {
        $p1 = 0;
        $p2 = 0;

        foreach ($this->passwords as $password) {
            preg_match("/^(\d+)-(\d+) ([a-z]): ([a-z]*)$/", $password, $matches);
            [, $min, $max, $char, $password] = $matches;

            // Part 1
            $occurences = substr_count($password, $char);
            $p1 += ($occurences >= $min && $occurences <= $max);

            // Part 2
            $p2 += ($password[$min - 1] === $char) ^ ($password[$max - 1] === $char);
        }

        return [$p1, $p2];
    }
}

$solution = new day02(filename: "passwords.txt");
[$p1, $p2] = $solution->getSolution();

echo("[Part 1]: {$p1}\n[Part 2]: {$p2}\n");