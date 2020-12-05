#!/usr/bin/python3
import re

def readInput(filename):
    file = open(filename, "r")
    data = file.readlines()
    exploded = []

    for line in data:
        matches = re.match(r"^(\d+)-(\d+) ([a-z]): ([a-z]*)$", line).groups()
        matches = [int(matches[0]), int(matches[1]), matches[2], matches[3]]
        exploded.append(matches)

    return exploded


def partOne(data):
    validCount = 0
    for line in data:
        charCount = line[3].count(line[2])
        if (charCount >= line[0] and charCount <= line[1]):
            validCount = validCount + 1
    
    print("[Part One]: {:d}".format(validCount))
    return


def partTwo(data):
    validCount = 0
    for line in data:
        charAtMin = line[3][line[0]-1] == line[2]
        charAtMax = line[3][line[1]-1] == line[2]
        if (charAtMin ^ charAtMax):
            validCount = validCount + 1
    
    print("[Part Two]: {:d}".format(validCount))
    return


input = readInput("passwords.txt")
partOne(input)
partTwo(input)