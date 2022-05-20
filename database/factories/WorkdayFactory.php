<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use App\Models\Workday;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkdayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workday::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> User::factory(),
            'channel_id'=> Channel::factory(),
            'submission_id'=> $this->faker->sentence,
            'completed'=> false,
        ];
    }

    // Defines workday as completed.
    public function statusCompleted(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'completed' => true,
            ];
        });
    }
}
