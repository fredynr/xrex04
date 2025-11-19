<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => fake()->name(),
            'first_surname' => fake()->lastName(),
            'sexo' => $this->faker->randomElement(['M','F']),
            'document'  => $this->faker->numberBetween($min = 79000000, $max = 79111111),
            'type_document' => $this->faker->randomElement(['cc','ti','te']),
            'direction' =>  $this->faker->address(),
            'phone' => $this->faker->numberBetween($min = 3200000000, $max = 3201111111),
            'email' => $this->faker->safeEmail,
            'birth' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
        ];
    }
}
