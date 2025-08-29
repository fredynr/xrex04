<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DeparturePlace;
use App\Models\EpsSender;
use App\Models\Patient;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'remision' => $this->faker->randomNumber(4, true),
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'eps_sender_id' => EpsSender::inRandomOrder()->first()->id,
            'departure_place_id' => DeparturePlace::inRandomOrder()->first()->id,
            'exam_state' => $this->faker->randomElement(['Solicitado', 'Devuelto']),
        ];
    }
}
