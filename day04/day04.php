<?php

function isValid(array $required, array $passport) : bool
{
	return array_intersect($required, array_keys($passport)) === $required;
}

function isDataValid(array $passport) : bool
{
	if ($passport["byr"] < 1920 || $passport["byr"] > 2002) {
		return false;
	}
	
	if ($passport["iyr"] < 2010 || $passport["iyr"] > 2020) {
		return false;
	}
	
	if ($passport["eyr"] < 2020 || $passport["eyr"] > 2030) {
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
	
	if (!preg_match("/^#[0-9a-f]{6}$/", $passport["hcl"])) {
		return false;
	}
	
	if (!preg_match("/^(amb|blu|brn|gry|grn|hzl|oth)$/", $passport["ecl"])) {
		return false;
	}
	
	if (!preg_match("/^\d{9}$/", $passport["pid"])) {
		return false;
	}
	
	return true;
}

$data = preg_split("/\n\s/m", file_get_contents("passports.txt"));
$required = ["byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid"];
$valid = 0;

foreach ($data as $passport) {
	$passport = str_replace("\n", " ", $passport);
	$passport = explode(" ", $passport);
	$passportKV = [];
	
	foreach ($passport as $parameters) {
		[$key, $value] = explode(":", $parameters);
		$passportKV[$key] = $value;
	}
	
	$passport = $passportKV;
	unset($passportKV);
	
	if (isValid(required: $required, passport: $passport) && isDataValid($passport)) {
		$valid++;
	}
}

echo("Found $valid passports." . PHP_EOL);