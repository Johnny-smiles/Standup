<?php

namespace Tests\Unit\SlackModal\ModalUpdate;

use App\Models\Workday;
use App\Support\Slack\Requests\Exceptions\MissingHashException;
use App\Support\Slack\Requests\Exceptions\MissingViewIdException;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\SlackRequest;
use App\Support\Slack\Requests\Triggers\Update\TriggerUpdate;
use App\Support\Slack\Requests\Triggers\Update\Views\EndOfDayView;
use App\Support\Slack\Requests\Triggers\Update\Views\StartOfDayView;
use App\Support\Slack\Requests\Triggers\Update\Views\WelcomeView;
use Tests\TestCase;
use Tests\Unit\SlackModal\MockBuilder;

class ModalUpdateTest extends TestCase
{
    use MockBuilder;

    protected Workday $workday;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workday = Workday::factory()->statusCompleted()->create();
    }

    /** @test */
    public function it_calls_modal_update()
    {
        $this->mockBuilder(
            TriggerUpdate::class,
            'handleSlackRequest'
        );

        (new SlackRequest(
            $this->transferObjectBuilder($this->workday)
                ->getRequest()
        ))->handle();
    }

    /** @test */
    public function it_requires_view_id()
    {
        $this->expectException(MissingViewIdException::class);

        (new WelcomeView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    []
                ))
            );
    }

    /** @test */
    public function it_requires_view_hash()
    {
        $this->expectException(MissingHashException::class);

        (new WelcomeView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    ['view' => ['id' => 'VIEW_ID']]
                ))
            );
    }

    /** @test */
    public function it_calls_welcome_modal()
    {
        $this->mockBuilder(
            WelcomeView::class,
            'buildResponse',
        );

        $withDeletedWorkday = $this->transferObjectBuilder($this->workday);

        $this->workday->delete();

        $withDeletedWorkday->setWorkday();

        (new TriggerUpdate($withDeletedWorkday))->handleSlackRequest();
    }

    /** @test */
    public function it_calls_start_of_day_modal()
    {
        $this->mockBuilder(
            StartOfDayView::class,
            'buildResponse',
        );

        (new TriggerUpdate($this->transferObjectBuilder($this->workday)))->handleSlackRequest();
    }

    /** @test */
    public function it_calls_end_of_day_modal()
    {
        $this->workday->update(['completed' => false]);

        $this->mockBuilder(
            EndOfDayView::class,
            'buildResponse',
        );

        (new TriggerUpdate($this->transferObjectBuilder($this->workday)))->handleSlackRequest();
    }

    protected function transferObjectBuilder(Workday $workday): SlackDataTransferObject
    {
        return (new SlackDataTransferObject([
            'type' => 'block_actions',
            'user' => [
                'id' => $workday->user->slack_id,
                'name' => $workday->user->name,
            ],
            'trigger_id' => '2501415723682.2258651156659',
            'team' => [
                'id' => $workday->channel->team->team_id,
            ],
            'view' => [
                'id' => 'VIEW_ID',
                'hash' => 'HASH_ID',
            ],
        ]
        ))
            ->setAndUpdateUser()
            ->setTeam()
            ->setBotToken()
            ->setWorkday();
    }
}
