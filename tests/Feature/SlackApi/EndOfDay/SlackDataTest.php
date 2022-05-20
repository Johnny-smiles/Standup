<?php

namespace Tests\Feature\EndOfDay;

use App\Models\Task;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\ModalTriggerStub;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\SubmissionStub;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\UpdateActionStubs;
use App\Support\Slack\Services\Slack;
use Tests\TestCase;

class SlackDataTest extends TestCase
{
    protected Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->completed()->create();
    }

    /** @test */
    public function it_opens_a_modal()
    {
        Slack::shouldReceive('openModal')
            ->withArgs(fn ($args) => $args === ModalTriggerStub::responseEndOfDayFromSlack($this->task))
            ->once();

        $this->post(
            route(
                'standups.index',
                ModalTriggerStub::requestEndOfDayFromSlack($this->task)
            )
        );
    }

    /** @test */
    public function it_updates_a_modal()
    {
        $this->task->update(['status' => 'completed']);

        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => $args === UpdateActionStubs::responseToSlack())
            ->once();

        $this->post(
            route(
                'standups.index',
                UpdateActionStubs::requestFromSlack($this->task)
            )
        );
    }

    /** @test */
    public function it_renders_a_response_message()
    {
        Slack::shouldReceive('postMessage')
            ->withArgs(fn ($args) => $args === SubmissionStub::messageStructureResponse($this->task))
            ->once();

        $this->post(
            route(
                'standups.index',
                SubmissionStub::requestFromSlack($this->task)
            )
        );
    }
}
