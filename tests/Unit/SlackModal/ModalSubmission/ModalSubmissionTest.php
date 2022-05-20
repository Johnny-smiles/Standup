<?php

namespace Tests\Unit\SlackModal\ModalSubmission;

use App\Models\Workday;
use App\Support\Slack\Requests\Exceptions\MissingTriggerIdException;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\SlackRequest;
use App\Support\Slack\Requests\Triggers\Submit\TriggerSubmit;
use App\Support\Slack\Requests\Triggers\Submit\Views\EndOfDayView;
use App\Support\Slack\Requests\Triggers\Submit\Views\StartOfDayView;
use App\Support\Slack\Requests\Triggers\Submit\Views\WelcomeView;
use Tests\TestCase;
use Tests\Unit\SlackModal\MockBuilder;

class ModalSubmissionTest extends TestCase
{
    use MockBuilder;

    protected Workday $workday;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workday = Workday::factory()->statusCompleted()->create();
    }

    /** @test */
    public function it_calls_view_submission()
    {
        $this->mockBuilder(
            TriggerSubmit::class,
            'handleSlackRequest'
        );

        (new SlackRequest(
            $this->transferObjectBuilder($this->workday)
                ->getRequest()
        ))->handle();
    }

    /** @test */
    public function it_requires_trigger_id()
    {
        $this->expectException(MissingTriggerIdException::class);

        (new WelcomeView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    []
                ))
            );
    }

    /** @test */
    public function it_calls_welcome_view()
    {
        $this->mockBuilder(
            WelcomeView::class,
            'buildResponse',
        );

        $withDeletedWorkday = $this->transferObjectBuilder($this->workday);

        $this->workday->delete();

        $withDeletedWorkday->setWorkday();

        (new TriggerSubmit($withDeletedWorkday))->handleSlackRequest();
    }

    /** @test */
    public function it_calls_start_of_day_view()
    {
        $this->mockBuilder(
            StartOfDayView::class,
            'buildResponse',
        );

        (new TriggerSubmit($this->transferObjectBuilder($this->workday)))->handleSlackRequest();
    }

    /** @test */
    public function it_calls_end_of_day_view()
    {
        $this->workday->update(['completed' => false]);

        $this->mockBuilder(
            EndOfDayView::class,
            'buildResponse',
        );

        (new TriggerSubmit($this->transferObjectBuilder($this->workday)))->handleSlackRequest();
    }

    protected function transferObjectBuilder(Workday $workday): SlackDataTransferObject
    {
        return (new SlackDataTransferObject([
            'type' => 'view_submission',
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
