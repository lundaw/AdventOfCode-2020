<?php

class day13 {
	private int $earliest;
	
	private array $buses;
	
	public function readInput(string $filename) : void
	{
		$data = file_get_contents(filename: $filename);
		[$earliest, $buses] = explode(separator: "\n", string: $data);
		$buses = explode(separator: ",", string: $buses);
		$buses = array_filter(array: $buses, callback: static fn(string $value) => $value !== 'x');
		$buses = array_map(callback: "intval", array: $buses);
		
		$this->earliest = $earliest;
		$this->buses = $buses;
	}
	
	public function earliestDeparture() : int
	{
		$min = PHP_INT_MAX;
		$minId = 0;
		
		foreach ($this->buses as $bus) {
			$departure = (int) ceil(num: $this->earliest / $bus) * $bus;
			
			if ($min > $departure) {
				$min = $departure;
				$minId = $bus;
			}
		}
		
		return $minId * ($min - $this->earliest);
	}
	
	public function earliestSubsequentDepartures() : int
	{
		return $this->chineseRemainder();
	}
	
	private function chineseRemainder() : int
	{
		$product = array_reduce(
			array: array_values($this->buses),
			callback: static fn($accumulator, $value) => $accumulator *= $value,
			initial: 1
		);
		$timestamp = 0;
		
		foreach ($this->buses as $offset => $time) {
			// Moving the offset to the other side (t+y ≡ 0 mod z => t ≡ -y mod z)
			$offset = $time - $offset % $time;
			$p = intdiv($product, $time);
			$pPrime = $this->modInverse(a: $p, b: $time);
			$timestamp += $offset * $pPrime * $p;
		}
		
		return $timestamp % $product;
	}
	
	private function modInverse(int $a, int $b) : int
	{
		if ($b === 1) {
			return 1;
		}
		
		$b_0 = $b;
		$x_0 = 0;
		$x_1 = 1;
		
		while ($a > 1) {
			// Quotient
			$q = intdiv($a, $b);
			
			$t = $b;
			$b = $a % $b;
			$a = $t;
			
			$t = $x_0;
			$x_0 = $x_1 - $q * $x_0;
			$x_1 = $t;
		}
		
		if ($x_1 < 0) {
			$x_1 += $b_0;
		}
		
		return $x_1;
	}
}

$solution = new day13();
$solution->readInput(filename: "input.txt");

echo("Earliest possible departure: {$solution->earliestDeparture()}\n");
echo("Earliest subsequent departure: {$solution->earliestSubsequentDepartures()}\n");
