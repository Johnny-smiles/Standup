<?php

namespace Tests\Unit\SlackModal\ModalSubmission\StartOfDay;

use App\Models\Workday;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\Views\StartOfDayView;
use Tests\TestCase;

class ConstructReturnMessageTest extends TestCase
{
    /** @test */
    public function it_has_data()
    {
        $actual = json_encode(
            (new StartOfDayView())->buildResponse(
                (new SlackDataTransferObject(
                    [
                        'user' => [
                            'id' => ($workday = Workday::factory()->create())->slack_id,
                            'name' => $workday->user->name,
                        ],
                        'trigger_id' => '2501415723682.2258651156659',
                        'team' => [
                            'id' => $workday->channel->team->team_id,
                        ],
                        'view' => [
                            'state' => ['values' => []],
                        ],
                    ]
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
            )
        );

        $this->assertStringContainsString($workday->user->name, $actual);
        $this->assertStringContainsString($workday->channel->slack_channel_id, $actual);
        $this->assertStringContainsString('image_url', $actual);
    }
}
