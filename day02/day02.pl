#!/usr/bin/perl
use warnings;
use strict;

my $file = 'passwords.txt';
open(FH, '<', $file) or die $!;

my $counter1 = 0;
my $counter2 = 0;

while (<FH>) {
    my @data = $_ =~ /^([0-9]+)-([0-9]+) ([a-z]): ([a-z]*)$/;
    my ($min, $max, $char, $password) = @data[0, 1, 2, 3];
    
    # Part 1
    my $count = () = $password =~ /$char/g;
    if ($count >= $min && $count <= $max) {
        $counter1++;
    }

    # Part 2
    if ((substr($password, $min - 1, 1) eq $char) ^ (substr($password, $max - 1, 1) eq $char)) {
        $counter2++;
    }
}

close(FH);
print "Part one valid: <$counter1>\nPart two valid: <$counter2>\n";