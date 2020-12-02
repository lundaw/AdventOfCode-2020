#include <iostream>
#include <fstream>
#include <algorithm>
#include <vector>
#include <string>
#include <tuple>

using quadruplet = std::tuple<std::size_t, std::size_t, char, std::string>;

auto readInput() noexcept {
	std::ifstream file("passwords.txt");
	std::vector<quadruplet> input{};
	std::string line;

	if (file.is_open()) {
		while (std::getline(file, line)) {
			std::size_t min, max;
			char c;
			std::string password;

			if (sscanf(line.c_str(), "%lu-%lu %c: %s\n", &min, &max, &c, &password[0]) == 4) {
				input.emplace_back(min, max, c, password.c_str());
			}
		}
		file.close();
	}
	else {
		std::cout << "Uh-oh, failed to open passwords.txt" << std::endl;
	}

	return input;
}

auto countValid_P1(const std::vector<quadruplet>& input) {
	return std::count_if(input.cbegin(), input.cend(), [](const quadruplet& input) -> bool {
		const std::string password = std::get<3>(input);
		std::size_t count = std::count(password.cbegin(), password.cend(), std::get<2>(input));

		return std::get<0>(input) <= count && count <= std::get<1>(input);
		});
}

auto countValid_P2(const std::vector<quadruplet>& input) {
	return std::count_if(input.cbegin(), input.cend(), [](const quadruplet& input) -> bool {
		const std::string password = std::get<3>(input);
		const char c = std::get<2>(input);
		const std::size_t first = std::get<0>(input), second = std::get<1>(input);

		return (password.at(first - 1) == c) ^ (password.at(second - 1) == c);
		});
}

int main() {
	auto input = readInput();

	std::cout << "Part One: " << countValid_P1(input) << std::endl;
	std::cout << "Part Two: " << countValid_P2(input) << std::endl;
}