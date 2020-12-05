#!/bin/sh

# Disclaimer #1: this solution uses the basic and lightweight SQLite3 database
#   engine, which you will need if you want to run it. Also it needs Perl, but
#   that is usually not a problem.
#
# Disclaimer #2: I was trying to do something similar because the constraint checks
#   would fit databases well, but this solution is better.
#   It was written by u/raevnos, props to him.
#   Source: https://www.reddit.com/r/adventofcode/comments/k6u6oq/2020_day_4_passport_information_really_should_be/

if [ $# -ne 2 ]; then
    echo "Usage: $0 PART1|PART2 INPUT"
    exit 1
fi

dbfile="day04.db"
input="$2"

# Create the necessary SQL table with constraints to automatically filter
# the records. Since SQLite contains only simple pattern matching, we need
# to repeat the repeating values, like digits in pid.
rm -f $dbfile # Start fresh
sqlite3 -batch $dbfile << 'EOF'
CREATE TABLE passports(
    id INTEGER PRIMARY KEY,
    byr INTEGER NOT NULL CHECK (byr BETWEEN 1920 AND 2002),
    iyr INTEGER NOT NULL CHECK (iyr BETWEEN 2010 AND 2020),
    eyr INTEGER NOT NULL CHECK (eyr BETWEEN 2020 AND 2030),
    hgt TEXT NOT NULL CHECK ((hgt GLOB '1[5-9][0-9]cm' AND CAST(hgt AS INTEGER) BETWEEN 150 AND 193) OR (hgt GLOB '[567][0-9]in' AND CAST(hgt AS INTEGER) BETWEEN 59 AND 76)),
    -- Since this is only basic pattern matching, there is only asterisk wildcard, so we gotta repeat
    hcl TEXT NOT NULL CHECK (hcl GLOB '#[0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f]'),
    ecl TEXT NOT NULL CHECK (ecl IN ('amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth')),
    -- Same as hcl, we need to repeat
    pid TEXT NOT NULL CHECK (pid GLOB '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'),
    cid -- cid does not matter :-(
);
EOF

# Oh god, oh no, Perl time :|
# -00 -> sets Perl to paragraph mode (special case) which treats two (or more) newlines
#     as record separator. That is exactly what we need!
# -a  -> automatically splits the input ($_) into an @F array variable.
# -n  -> makes the program loop, which is good for our input
# -E  -> gives us the possibility to write our code in the shell with optional
#        features enabled as well.
part="$1" perl -00 -anE '
BEGIN {
    # Making the database ignorant for the first part, which does
    # not require data validation for the passport data
    say "PRAGMA ignore_check_constraints = true;" if $ENV{part} eq "PART1";
    
    # Collect them into one transaction instead of autocommit after every insert
    say "BEGIN TRANSACTION;"
}

# We can make use of the -a switch and use the automatically split input as @F
my @columns = map { s/(\w+?):.*/$1/r } @F;
my $columnsStr = join(",", @columns);

my @values = map { s/\w+?:(.*)/"$1"/r } @F;
my $valuesStr = join(",", @values);

# Using say, because it automatically puts a newline
say "INSERT OR IGNORE INTO passports(", $columnsStr, ") VALUES (", $valuesStr, ");";

END { say "COMMIT;" }
' "$input" | sqlite3 -batch $dbfile

# Calculate the answers we need, which is simple now.
sqlite3 -batch -header -column $dbfile << EOF
SELECT count(id) AS Result FROM passports;
EOF