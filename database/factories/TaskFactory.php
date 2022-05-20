<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Workday;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $user = User::factory()->create(),
            'workday_id' => Workday::factory()->for($user),
            'text' => $this->faker->sentence,
        ];
    }

    // Defines task as completed.
    public function completed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'text' => 'completed',
                'status'=> 'completed',
            ];
        });
    }
}
