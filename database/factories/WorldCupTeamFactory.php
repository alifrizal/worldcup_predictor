<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WorldCupTeamFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->country();
        return [
            'name'       => $name,
            'code'       => strtoupper(Str::random(3)),
            'flag_emoji' => '🏳️',
            'group'      => $this->faker->randomElement(range('A', 'L')),
            'slug'       => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
        ];
    }
}
