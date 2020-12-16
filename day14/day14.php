<?php

class day14
{
	private array $input;
	
	public function __construct(string $filename)
	{
		$data = file_get_contents(filename: $filename);
		$data = explode(separator: "\n", string: $data);
		
		$this->input = $data;
	}
	
	public function version1() : int
	{
		$mem = [];
		$mask = NULL;
		
		foreach ($this->input as $line) {
			if (str_contains(haystack: $line, needle: "mask")) {
				$mask = explode(separator: " = ", string: $line)[1];
				continue;
			}
			
			$matches = NULL;
			preg_match(pattern: "/^mem\[(\d+)] = (\d+)$/", subject: $line, matches: $matches);
			[, $memAddress, $memValueDecimal] = $matches;
			$memValueBinary = sprintf("%036s", decbin(num: $memValueDecimal));
			
			$result = "";
			for ($i = 0; $i < 36; $i++) {
				$result .= match ($mask[$i]) {
					"X" => $memValueBinary[$i],
					"0", "1" => $mask[$i]
				};
			}
			$mem[(int) $memAddress] = bindec(binary_string: $result);
		}
		
		return array_sum(array: $mem);
	}
	
	public function version2() : int
	{
		$mem = [];
		$mask = NULL;
		
		foreach ($this->input as $line) {
			if (str_contains(haystack: $line, needle: "mask")) {
				$mask = explode(separator: " = ", string: $line)[1];
				continue;
			}
			
			$matches = NULL;
			preg_match(pattern: "/^mem\[(\d+)] = (\d+)$/", subject: $line, matches: $matches);
			[, $memAddressDecimal, $memValue] = $matches;
			$memAddressBinary = sprintf("%036s", decbin(num: $memAddressDecimal));
			
			$result = "";
			for ($i = 0; $i < 36; $i++) {
				$result .= match ($mask[$i]) {
					"X" => "X",
					"0" => $memAddressBinary[$i],
					"1" => "1"
				};
			}
			
			$floatingAddresses = [];
			$this->getFloatingAddresses(address: $result, results: $floatingAddresses);
			$floatingAddresses = array_map(callback: "bindec", array: $floatingAddresses);
			foreach ($floatingAddresses as $floatingAddress) {
				$mem[$floatingAddress] = $memValue;
			}
		}
		
		return array_sum(array: $mem);
	}
	
	private function getFloatingAddresses(string $address, int $charIdx = 0, array &$results = []) : void
	{
		if ($charIdx === strlen(string: $address)) {
			$results[] = $address;
			return;
		}
		
		// Bruteforcing every combination with a nice copy-paste code
		$nextCharIdx = $charIdx + 1;
		if ($address[$charIdx] === "X") {
			$address[$charIdx] = "0";
			$this->getFloatingAddresses(address: $address, charIdx: $nextCharIdx, results: $results);
			
			$address[$charIdx] = "1";
			$this->getFloatingAddresses(address: $address, charIdx: $nextCharIdx, results: $results);
		}
		else {
			$this->getFloatingAddresses(address: $address, charIdx: $nextCharIdx, results: $results);
		}
	}
}

$solution = new day14(filename: "initprogram.txt");

$version1 = $solution->version1();
echo("[Part 1]: {$version1}\n");

$version2 = $solution->version2();
echo("[Part 2]: {$version2}\n");