<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'identifier' => $this->faker->word,
            'enabled' => $this->faker->boolean,
            'family' => $this->faker->word,
            'categories' => [],
            'groups' => [],
        ];
    }
}
