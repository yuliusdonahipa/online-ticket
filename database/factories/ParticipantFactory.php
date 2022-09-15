<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $events = \App\Models\Event::pluck('id')->toArray();

        return [
            'event_id' => $this->faker->randomElement($events),
            'uuid' => 'EVENT' . date('y') . date('m') . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
        ];
    }
}
