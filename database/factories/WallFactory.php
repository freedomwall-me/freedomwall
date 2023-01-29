<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WallFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'tags' => $this->faker->words(),
            'body' => $this->faker->word(),
            'publish_status' => /* published|draft */ $this->faker->randomElement(['published', 'draft']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
