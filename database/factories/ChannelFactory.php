<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Channel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word,
            'slack_channel_id'=>$this->faker->word,
            'team_id'=>Team::factory(),
        ];
    }
}
