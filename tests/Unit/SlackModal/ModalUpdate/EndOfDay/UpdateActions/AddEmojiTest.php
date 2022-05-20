<?php

namespace Tests\Unit\SlackModal\ModalUpdate\EndOfDay\UpdateActions;

use App\Models\Task;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskSummaryBlock;
use Tests\TestCase;

class AddEmojiTest extends TestCase
{
    /** @test */
    public function it_adds_complete_emoji()
    {
        $actual = (new TaskSummaryBlock())->build(Task::factory()->create(['status' => 'completed']))['elements'][1]['image_url'];

        $this->assertEquals(config('services.slack.slack_emoji_checkmark'), $actual);
    }

    /** @test */
    public function it_adds_blocked_emoji()
    {
        $actual = (new TaskSummaryBlock())->build(Task::factory()->create(['status' => 'blocked']))['elements'][1]['image_url'];

        $this->assertEquals(config('services.slack.slack_emoji_crossmark'), $actual);
    }

    /** @test */
    public function it_adds_delete_emoji()
    {
        $actual = (new TaskSummaryBlock())->build(Task::factory()->create(['status' => 'deleted']))['elements'][1]['image_url'];

        $this->assertEquals(config('services.slack.slack_emoji_wastebin'), $actual);
    }

    /** @test */
    public function it_adds_in_progress_emoji()
    {
        $actual = (new TaskSummaryBlock())->build(Task::factory()->create(['status' => 'in_progress']))['elements'][1]['image_url'];

        $this->assertEquals(config('services.slack.slack_emoji_construction'), $actual);
    }
}
