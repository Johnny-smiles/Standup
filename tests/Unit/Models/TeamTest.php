<?php

namespace Tests\Unit\Models;

use App\Models\Channel;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class TeamTest extends TestCase
{
    /** @test */
    public function it_belongs_to_many_users()
    {
        $team = Team::factory()->create();
        $users = User::factory()->count(2)->create();
        $team->users()->attach([
            $users[0]->getKey(),
            $users[1]->getKey(),
        ]);

        $results = $team->users;

        foreach ($users as $user) {
            $this->assertTrue($results->contains($user));
        }
    }

    /** @test */
    public function it_has_a_channel()
    {
        $team = Team::factory()->create();
        $channel = Channel::factory()->create(['team_id' => $team->getKey()]);

        $this->assertTrue($team->channel->is($channel));
    }
}
