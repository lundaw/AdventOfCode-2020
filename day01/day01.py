#!/usr/bin/python3

def readInput(filename):
    file = open(filename, "r")
    data = file.readlines()
    data = [int(value) for value in data]

    return data


def partOne(data):
    for i in data:
        for j in data:
            if (i+j) == 2020:
                print("[Part One]: {:d}".format(i*j))
                return


def partTwo(data):
    for i in data:
        for j in data:
            for k in data:
                if i+j+k == 2020:
                    print("[Part Two]: {:d}".format(i*j*k))
                    return


data = readInput("input.txt")
partOne(data)
partTwo(data)