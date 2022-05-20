<?php

namespace Tests\Unit\SlackModal\ModalUpdate\StartOfDay;

use App\Models\Workday;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\AddTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\DeleteTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\EditTaskStub;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\Views\StartOfDayView;
use Illuminate\Support\Arr;
use Tests\TestCase;

class StartOfDayUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->workday = Workday::factory()->statusCompleted()->create();
    }

    /** @test */
    public function it_adds_a_task_block()
    {
        $actual = (new StartOfDayView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    AddTaskStub::requestFromSlack(
                        $this->workday,
                    )
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            );

        $this->assertEquals('input_with_dispatch_task_1', Arr::get($actual, 'view.blocks.1.block_id'));
    }

    /** @test */
    public function it_has_more_than_two_tasks()
    {
        $actual = (new StartOfDayView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    DeleteTaskStub::requestFromSlackTwoOrMoreTasks(
                        $this->workday,
                    )
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            );

        $this->assertCount(5, $actual['view']['blocks']);
    }

    /** @test */
    public function it_has_one_tasks_on_delete()
    {
        $actual = (new StartOfDayView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    DeleteTaskStub::requestFromSlackTwoTasks(
                        $this->workday,
                    )
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            );

        $this->assertCount(4, $actual['view']['blocks']);
    }

    /** @test */
    public function it_has_data()
    {
        $actual = (new StartOfDayView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    EditTaskStub::requestFromSlack(
                        $this->workday,
                    )
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            );

        $this->assertEquals('remove_block_task_1', Arr::get($actual, 'view.blocks.1.block_id'));
        $this->assertEquals('remove_block_task_2', Arr::get($actual, 'view.blocks.3.block_id'));
    }
}
