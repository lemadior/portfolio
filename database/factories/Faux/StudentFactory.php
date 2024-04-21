<?php

namespace Database\Factories\Faux;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faux\Student>
 */
class StudentFactory extends Factory
{
    const INITIAL_AMOUNT = 20;

    /**
     * @var array $firstName
     */
    protected $firstName = [
        "Evert",
        "Dora",
        "Ethel",
        "Madeline",
        "Sienna",
        "Tabitha",
        "Madonna",
        "Lucas",
        "Jacques",
        "Christop",
        "Estelle",
        "Camden",
        "Enola",
        "Kellen",
        "Jaquelin",
        "Danny",
        "Elias",
        "Keira",
        "Vernie",
        "Domenica"
    ];

    /**
     * @var array $lastName
     */
    protected $lastName = [
        "Jones",
        "Prosacco",
        "Padberg",
        "Cummings",
        "Beer",
        "McKenzie",
        "Jacobs",
        "Gusikowski",
        "Grady",
        "Kautzer",
        "Cruickshank",
        "Parker",
        "Bosco",
        "Denesik",
        "Kris",
        "Moen",
        "Skiles",
        "Ernser",
        "Zemlak",
        "Kutch"
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fullName = [];

        // Take each first name of the student
        for ($i = 0; $i < self::INITIAL_AMOUNT; $i++) {
            $j=0;

            // Add randomly chooses last names to the first name (take half of initial amount)
            while ($j < self::INITIAL_AMOUNT/2 + 1) {
                $lastNameIndex = rand(0, self::INITIAL_AMOUNT - 1);

                $fname = $this->firstName[$i] . " " . $this->lastName[$lastNameIndex];

                if (in_array($fname, $fullName, true)) {
                    continue;
                }

                $fullName[] = $fname;

                $j++;
            }
        }

        shuffle($fullName);

        $name = explode(" ", fake()->unique()->randomElement($fullName));

        return [
            'group_id' => null,
            'first_name' => $name[0],
            'last_name' => $name[1]
        ];
    }
}
