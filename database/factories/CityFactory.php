<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CityFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->city();
        return [
            'name'    => $name,
            'country' => $this->faker->country(),
            'region'  => $this->faker->randomElement(['indonesia', 'international']),
            'slug'    => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
        ];
    }
}
