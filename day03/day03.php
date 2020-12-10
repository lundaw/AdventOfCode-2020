<?php

class Solution {
    private array $data;

    private array $routes = [];

    public function readInput(string $filename) : void 
    {
        $this->data = explode(
            separator: "\n",
            string: file_get_contents(filename: $filename)
        );
    }

    public function calculateRoute(int $right = 1, int $down = 1) : int
    {
        $routeName = "R{$right}D{$down}";
        if (!array_key_exists(key: $routeName, array: $this->routes)) {
            $this->routes[$routeName] = 0;

            for($y = 0; $y < count($this->data); $y += $down) {
                // y = mx+b
                $x = (($right * $y) / $down) % 31;
                $this->routes[$routeName] += $this->data[$y][$x] === '#';
            }
        }

        return $this->routes[$routeName];
    }

    public function calculateProductOfRoutes() : int
    {
        $product = 1;

        $product *= $this->calculateRoute();
        $product *= $this->calculateRoute(right: 3);
        $product *= $this->calculateRoute(right: 5);
        $product *= $this->calculateRoute(right: 7);
        $product *= $this->calculateRoute(right: 1, down: 2);

        return $product;
    }
}

$solution = new Solution();
$solution->readInput(filename: "map.txt");

$r3d1 = $solution->calculateRoute(right: 3, down: 1);
echo("Trees encountered on R3D1 movement: {$r3d1}\n");

$product = $solution->calculateProductOfRoutes();
echo("Product of the routes: {$product}\n");
