<?php

$data = file_get_contents(filename: "input.txt");
$data = explode(separator: "\n", string: $data);
$instructions = [];

foreach ($data as $instruction) {
    preg_match(
        pattern: "/^(nop|acc|jmp) ([\+-]\d+)$/",
        subject: $instruction,
        matches: $matches
    );
    [, $operation, $offset] = $matches;
    array_push($instructions, [
        "op" => $operation,
        "offset" => (int) $offset,
        "executed" => false
    ]);
}

function runUntilRepeatedOp(array $instructions, int &$acc) : bool {
    for ($i = 0; $i < count($instructions); $i++) {
        if ($instructions[$i]["executed"]) {
            return false;
        }
    
        $instructions[$i]["executed"] = true;
        
        match ($instructions[$i]["op"]) {
            "acc" => $acc += $instructions[$i]["offset"],
            "jmp" => $i += $instructions[$i]["offset"] - 1, // Correction for i++
            default => null,
        };
    }

    return true;
}

function fixInstructions(array $instructions) : int {
    $acc = 0;

    for ($i = 0; $i < count($instructions); $i++) {
        $modifiedInstructions = $instructions;
        $modifiedAcc = 0;

        if (runUntilRepeatedOp($modifiedInstructions, $modifiedAcc)) {
            return $modifiedAcc;
        }

        if ($modifiedInstructions[$i]["op"] === "nop") {
            $modifiedInstructions[$i]["op"] = "jmp";
            $modifiedAcc = 0;

            if (runUntilRepeatedOp($modifiedInstructions, $modifiedAcc)) {
                return $modifiedAcc;
            }
        }

        if ($modifiedInstructions[$i]["op"] === "jmp") {
            $modifiedInstructions[$i]["op"] = "nop";
            $modifiedAcc = 0;
             
            if (runUntilRepeatedOp($modifiedInstructions, $modifiedAcc)) {
                return $modifiedAcc;
            }
        }
    }

    return $acc;
}

$repeatedAcc = 0;
runUntilRepeatedOp(instructions: $instructions, acc: $repeatedAcc);
echo(sprintf("[Part 1]: Repeated execution, accumulator value: %d\n", $repeatedAcc));

$fixedAcc = fixInstructions(instructions: $instructions);
echo(sprintf("[Part 2]: Accumulator after fixed: %d\n", $fixedAcc));