<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_at' => $this->faker->dateTime(),
            'end_at' => fn ($data) => Carbon::parse($data['start_at'])->addHours(2),
            'description' => $this->faker->text(),
        ];
    }
}
