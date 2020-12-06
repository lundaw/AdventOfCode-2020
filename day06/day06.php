<?php

function anyoneAnsweredYes(array $answers) : int {
    return count(array_filter($answers, function (int $value) {
        return $value > 0;
    }));
}

function everyoneAnsweredYes(array $answers, int $groupSize) : int {
    return count(array_filter($answers, function (int $value) use ($groupSize) {
        return $value === $groupSize;
    }));
}

$data = preg_split("/\n\s/m", file_get_contents("answers.txt"));
$countPartOne = $countPartTwo = 0;

foreach($data as $group) {
    $answers = array_fill_keys(array_values(range("a", "z")), 0);
    $groupAnswers = explode("\n", $group);

    foreach($groupAnswers as $answer) {
        foreach(str_split($answer) as $yes) {
            $answers[$yes]++;
        }
    }

    $countPartOne += anyoneAnsweredYes($answers);
    $countPartTwo += everyoneAnsweredYes($answers, count($groupAnswers));
}

echo("[Part one]: {$countPartOne}\n");
echo("[Part two]: {$countPartTwo}\n");