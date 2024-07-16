<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Event;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'eventName' => $this->faker->word(),
            'eventImage' => $this->faker->text(),
            'startDate' => $this->faker->date(),
            'endingDate' => $this->faker->date(),
        ];
    }
}
