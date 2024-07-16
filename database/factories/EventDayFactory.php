<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Day;
use App\Models\Event;
use App\Models\EventDay;

class EventDayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventDay::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ticketAmount' => $this->faker->word(),
            'refDate' => $this->faker->date(),
            'event_id' => Event::factory(),
            'day_id' => Day::factory(),
        ];
    }
}
