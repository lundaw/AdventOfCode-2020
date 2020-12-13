<?php

class day06 {
    private array $groups;

    public function __construct(string $filename)
    {
        $input = file_get_contents($filename);
        $input = preg_split("/\n\s/m", $input);

        $this->groups = $input;
    }

    public function getSolution() : array
    {
        $p1 = 0;
        $p2 = 0;
        
        foreach ($this->groups as $group) {
            $answers = array_fill_keys(range("a", "z"), 0);
            $groupAnswers = explode("\n", $group);

            foreach ($groupAnswers as $answer) {
                foreach (str_split($answer) as $yes) {
                    $answers[$yes]++;
                }
            }

            $p1 += $this->anyoneAnsweredYes($answers);
            $p2 += $this->everyoneAnsweredYes($answers, count($groupAnswers));
        }

        return [$p1, $p2];
    }

    private function anyoneAnsweredYes(array $answers) : int
    {
        return count(array_filter($answers, fn (int $value) => $value > 0));
    }

    private function everyoneAnsweredYes(array $answers, int $groupSize) : int
    {
        return count(array_filter($answers, fn (int $value) => $value === $groupSize));
    }
}

$solution = new day06("answers.txt");
[$p1, $p2] = $solution->getSolution();

echo("[Part 1]: {$p1}\n");
echo("[Part 2]: {$p2}\n");