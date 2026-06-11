<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FixtureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'match_time' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'stage'      => 'group',
            'group'      => $this->faker->randomElement(range('A', 'L')),
            'venue'      => $this->faker->city(),
            'status'     => 'scheduled',
            'home_score' => null,
            'away_score' => null,
        ];
    }
}
