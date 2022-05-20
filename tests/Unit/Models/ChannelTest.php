<?php

namespace Tests\Unit\Models;

use App\Models\Channel;
use App\Models\Team;
use App\Models\Workday;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_team()
    {
        $team = Team::factory()->create();
        $channel = Channel::factory()->create(['team_id' => $team->getKey()]);

        $results = $channel->team;

        $this->assertTrue($results->is($team));
    }

    /** @test */
    public function it_has_many_workdays()
    {
        $channel = Channel::factory()->create([
            'team_id' => Team::factory()->create()->getKey(),
        ]);
        $workdays = Workday::factory()->count(2)->create([
            'channel_id' => $channel->getkey(),
        ]);

        foreach ($workdays as $workday) {
            $this->assertTrue($channel->workdays->contains($workday));
        }
    }
}
