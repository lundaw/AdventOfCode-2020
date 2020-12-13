#!/usr/bin/python3
from math import prod
from itertools import combinations

def readInput(filename):
    file = open(filename, "r")
    data = [int(value) for value in file.readlines()]

    return data


def solve(elements):
    for combination in combinations(data, elements):
        if sum(combination) == 2020:
            return prod(combination)


data = readInput("input.txt")
print("[Part 1]: {:d}".format(solve(2)))
print("[Part 2]: {:d}".format(solve(3)))