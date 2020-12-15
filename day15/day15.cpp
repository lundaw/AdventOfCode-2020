// Compilation requires C++17 standard

#include <iostream>
#include <array>
#include <vector>
#include <algorithm>

int play(const auto& startingNumbers, const std::size_t limit) noexcept {
	std::vector<int> numbers(limit); // Preallocate space
	std::size_t turn{ 1 };
	int lastNumber{ startingNumbers.back() };

    // Initialize with starting numbers before proceeding to the main game
	std::for_each(startingNumbers.begin(), std::prev(startingNumbers.end()), [&numbers, &turn](auto value) {
		numbers[value] = turn;
		turn++;
	});

	while (turn < limit) {
		int next = (numbers[lastNumber] == 0) ? 0 : (turn - numbers[lastNumber]);
		numbers[lastNumber] = turn;
		lastNumber = next;
		turn++;
	}

	return lastNumber;
}

int main() {
	constexpr std::array numbers{ 16, 11, 15, 0, 1, 7 };

	std::cout << "[Part 1]: " << play(numbers, 2'020) << std::endl;
	std::cout << "[Part 2]: " << play(numbers, 30'000'000) << std::endl;

	return 0;
}