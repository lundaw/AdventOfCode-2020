<?php

class day04 {
	private array $passports;

	private array $requiredFields = [
		"byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid"
	];

	public function __construct(string $filename)
	{
		$input = file_get_contents(filename: "passports.txt");
		$input = preg_split("/\n\s/m", $input);

		$this->passports = $input;
	}

	public function getValidPassports() : array
	{
		$valid_p1 = 0;
		$valid_p2 = 0;

		foreach ($this->passports as $passport) {
			$passport = str_replace("\n", " ", $passport);
			$passport = explode(" ", $passport);
			$passportKV = [];
			
			foreach ($passport as $parameters) {
				[$key, $value] = explode(":", $parameters);
				$passportKV[$key] = $value;
			}
			
			$passport = $passportKV;
			unset($passportKV);
			
			if ($this->isValidPassport(passport: $passport)) {
				$valid_p1++;

				if ($this->isAllDataValid($passport)) {
					$valid_p2++;
				}
			}
		}

		return [$valid_p1, $valid_p2];
	}

	private function isValidPassport(array $passport) : bool
	{
		return array_intersect($this->requiredFields, array_keys($passport)) === $this->requiredFields;
	}

	private function isAllDataValid(array $passport) : bool
	{
		if (($passport["byr"] < 1920 || $passport["byr"] > 2002)
			|| ($passport["iyr"] < 2010 || $passport["iyr"] > 2020)
			|| ($passport["eyr"] < 2020 || $passport["eyr"] > 2030)
			|| (!preg_match("/^#[0-9a-f]{6}$/", $passport["hcl"]))
			|| (!preg_match("/^(amb|blu|brn|gry|grn|hzl|oth)$/", $passport["ecl"]))
			|| (!preg_match("/^\d{9}$/", $passport["pid"]))) {
			return false;
		}
	
		if (preg_match("/^(\d+)(cm|in)$/", $passport["hgt"], $hgt)) {
			[, $val, $unit] = $hgt ?: [];
			if (($unit === "cm" && ($val < 150 || $val > 193)) || ($unit === "in" && ($val < 59 || $val > 76))) {
				return false;
			}
		}
		else {
			return false;
		}
	
		return true;
	}
}

$solution = new day04(filename: "passports.txt");
[$p1, $p2] = $solution->getValidPassports();

echo("[Part 1]: {$p1} passports\n[Part 2]: {$p2} passports\n");