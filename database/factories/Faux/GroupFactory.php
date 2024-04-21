<?php

namespace Database\Factories\Faux;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faux\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => strtoupper(fake()->unique()->regexify('[A-Za-z]{2}-2[0-4]{1}'))
        ];
    }
}
