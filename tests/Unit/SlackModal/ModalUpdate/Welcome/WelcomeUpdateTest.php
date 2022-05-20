<?php

namespace Tests\Unit\SlackModal\ModalUpdate\Welcome;

use App\Models\Channel;
use App\Models\User;
use App\Support\Slack\Blueprints\Stubs\Welcome\WelcomeUpdateStub;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\Views\WelcomeView;
use Illuminate\Support\Arr;
use Tests\TestCase;

class WelcomeUpdateTest extends TestCase
{
    /** @test */
    public function it_has_data()
    {
        $actual = (new WelcomeView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    WelcomeUpdateStub::requestFromSlack(
                        Channel::factory()->create(),
                        User::factory()->create()
                    )
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            );

        $this->assertEquals(config('services.slack.slack_thumbs_up'), Arr::get($actual, 'view.blocks.1.image_url'));
    }
}
