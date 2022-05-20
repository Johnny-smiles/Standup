<?php

namespace Unit\SlackModal\ModalSubmission\EndOfDay;

use App\Models\Task;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\Views\EndOfDayView;
use Tests\TestCase;

class ActionsTest extends TestCase
{
    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->create([
            'status' => null,
            'text' => 'completed',
        ]);
    }

    /** @test */
    public function it_updates_workday_status()
    {
        (new EndOfDayView())
            ->buildResponse(
                $this->transferObjectBuilder()
            );

        $this->assertDatabaseHas('workdays', ['completed' => 'true']);
    }

    /** @test */
    public function construct_return_message()
    {
        $actual = (new EndOfDayView())
            ->buildResponse(
                $this->transferObjectBuilder()
            );

        // indentation intentonal to match:
        // "text" => """
        //          Today:\n
        //          • completed\n
        //          """
        $this->assertEquals('Today:
• completed
', $actual['blocks'][0]['text']['text']);
    }

    /** @test */
    public function construct_return_message_with_emoji()
    {
        $this->task->workday->tasks()->update([
            'status' => 'completed',
        ]);

        $actual = (new EndOfDayView())
            ->buildResponse(
                $this->transferObjectBuilder()
            );

        // indentation intentonal to match:
        // "text" => """
        //          Today:\n
        //          • completed ✅\n
        //          """
        $this->assertEquals('Today:
• completed ✅
', $actual['blocks'][0]['text']['text']);
    }

    protected function transferObjectBuilder(): SlackDataTransferObject
    {
        return (new SlackDataTransferObject([
            'user' => [
                'id' => $this->task->workday->user->slack_id,
                'name' => $this->task->workday->user->name,
            ],
            'trigger_id' => '2501415723682.2258651156659',
            'team' => [
                'id' => $this->task->workday->channel->team->team_id,
            ],
            'view' => [
                'state' => ['values' => []],
            ],
        ]
        ))
            ->setAndUpdateUser()
            ->setTeam()
            ->setWorkday();
    }
}
