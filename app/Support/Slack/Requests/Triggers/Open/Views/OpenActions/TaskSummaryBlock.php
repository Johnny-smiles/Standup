<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views\OpenActions;

use App\Models\Task;
use App\Support\Slack\Requests\Blocks\Text\Accessory\ImageElement;
use App\Support\Slack\Requests\Blocks\Text\ContextBlock;
use App\Support\Slack\Requests\Blocks\Text\TextElement;
use App\Support\Slack\Requests\Blocks\Text\TimeElement;
use Illuminate\Support\Collection;

class TaskSummaryBlock
{
    public function build(Task $task): array
    {
        $block = Collection::empty();

        $block
            ->push(
                (new TextElement())
                    ->setText($task->text)
                    ->render()
            );

        if ($task->time) {
            $block->push(
                (new TimeElement())
                    ->setText($task->time)
                    ->render()
            );
        }
        if ($task->status) {
            $block->push(
                (new ImageElement())
                    ->setImage(
                        match ($task->status) {
                            'completed' => config('services.slack.slack_emoji_checkmark'),
                            'blocked' => config('services.slack.slack_emoji_crossmark'),
                            'deleted' => config('services.slack.slack_emoji_wastebin'),
                            default => config('services.slack.slack_emoji_construction'),
                        }
                    )->render()
            );
        }

        return (new ContextBlock($block->toArray()))->setId($task->getKey())->render();
    }
}
