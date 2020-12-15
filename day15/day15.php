<?php

class day15
{
	/**
	 * @var int[]
	 */
	private array $input = [
		16, 11, 15, 0, 1, 7,
	];
	
	/**
	 * @param int $limit Sets the limit for how many rounds (aka numbers) the game
	 *                   is played with the elves.
	 *
	 * @return int The last number of the game when the limit is reached.
	 */
	public function play(int $limit) : int
	{
		$numbers = $this->input;
		$lastOccurrence = array_flip(array: $numbers);
		$numberCount = count(value: $numbers); // Assigning it to var to avoid counting at every iteration
		
		for ($i = count(value: $numbers) - 1; $numberCount < $limit; $i++, $numberCount++) {
			if (!isset($lastOccurrence[end(array: $numbers)])) {
				$numbers[] = 0;
			}
			else {
				$newNumber = $i - $lastOccurrence[end(array: $numbers)];
				$numbers[] = $newNumber;
			}
			$lastOccurrence[$numbers[$i]] = $i;
			
			// A little information that it is still going
			if ($i % 10_000_000 === 0) {
				echo("Calculating... iteration #{$i} finished.\n");
			}
		}
		
		return end(array: $numbers);
	}
}

$solution = new day15();

$p1 = $solution->play(limit: 2_020);
echo("[Part 1]: {$p1}\n");

$p2 = $solution->play(limit: 30_000_000);
echo("[Part 2]: {$p2}\n");
