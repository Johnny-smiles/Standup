<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views\OpenActions;

use App\Support\Slack\Requests\Blocks\Text\Accessory\ImageElement;
use App\Support\Slack\Requests\Blocks\Text\MarkdownTextBlockWithAccessory;

class AddEmoji
{
    public function __invoke(int $taskId, string $text, string $status): array
    {
        return (new MarkdownTextBlockWithAccessory())
            ->setId($taskId)
            ->setText($text)
            ->setAccessory((new ImageElement())
                ->setImage(
                    match ($status) {
                        'completed' => config('services.slack.slack_emoji_checkmark'),
                        'blocked' => config('services.slack.slack_emoji_crossmark'),
                        'delete' => config('services.slack.slack_emoji_wastebin'),
                        default => config('services.slack.slack_emoji_construction'),
                    }
                )->render()
            )->render();
    }
}
