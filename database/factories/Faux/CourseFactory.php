<?php

namespace Database\Factories\Faux;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faux\Course>
 */
class CourseFactory extends Factory
{
    protected $disciplines = [
        ['Math', 'Language of God to create Universes'],
        ['Biology', 'What inside the creatures'],
        ['Pneumatology', 'Learn how works pneumatic weapon'],
        ['History', 'Forgot all you know before'],
        ['Astronomy', 'We are not alone'],
        ['Philosophy', 'To be or not to be'],
        ['Chemistry', 'Miracle is possible'],
        ['Physics', 'Gravity is not a force. It is a wave'],
        ['Linguistics', 'How to say HELLO in Klingon'],
        ['Economics', 'Why am I so poor']
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discipline = fake()->unique()->randomElement($this->disciplines);

        return [
            'name' => $discipline[0],
            'description' => $discipline[1]
        ];
    }
}
