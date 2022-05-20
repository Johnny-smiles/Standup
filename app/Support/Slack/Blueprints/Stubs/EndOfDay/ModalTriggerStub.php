<?php

namespace App\Support\Slack\Blueprints\Stubs\EndOfDay;

use App\Models\Task;

class ModalTriggerStub
{
    public static function requestEndOfDayFromSlack(Task $task): array
    {
        return [
            'team_id' => $task->workday->channel->team->team_id,
            'channel_id' => $task->workday->channel->slack_channel_id,
            'channel_name' => $task->workday->channel->name,
            'user_id' => $task->workday->user->slack_id,
            'user_name' => $task->workday->user->name,
            'trigger_id' => 'TRIGGER_ID',
        ];
    }

    public static function responseEndOfDayFromSlack(Task $task): array
    {
        return [
            'channel' => $task->workday->channel->slack_channel_id,
            'trigger_id' => 'TRIGGER_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Accomplished today',
                ],
                'blocks' => [
                    0 => [
                        'type' => 'context',
                        'block_id' => 'task_1',
                        'elements' => [
                            0 => [
                                'type' => 'mrkdwn',
                                'text' => $task->text,
                            ],
                            1 => [
                                'type' => 'image',
                                'image_url' => config('services.slack.slack_emoji_checkmark'),
                                'alt_text' => '',
                            ],
                        ],
                    ],
                    1 => ResponseBlocks::taskStatusSelect(),
                    2 => [
                        'type' => 'divider',
                        'block_id' => 'divider',
                    ],
                    3 => ResponseBlocks::editTaskButtonBlock(),
                    4 => ResponseBlocks::unlinkedGitHubBlock(),
                ],
                'submit' => [
                    'type' => 'plain_text',
                    'text' => 'Workday Completed',
                ],
                'close' => [
                    'type' => 'plain_text',
                    'text' => 'Close',
                ],
            ],
        ];
    }

    public static function responseEndOfDayFromSlackWithGitHubIssues(Task $task): array
    {
        return [
            'channel' => $task->workday->channel->slack_channel_id,
            'trigger_id' => 'TRIGGER_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Accomplished today',
                ],
                'blocks' => [
                    0 => [
                        'type' => 'context',
                        'block_id' => 'task_1',
                        'elements' => [
                            0 => [
                                'type' => 'mrkdwn',
                                'text' => $task->text,
                            ],
                            1 => [
                                'type' => 'image',
                                'image_url' => config('services.slack.slack_emoji_checkmark'),
                                'alt_text' => '',
                            ],
                        ],
                    ],
                    1 => ResponseBlocks::taskStatusSelect(),
                    2 => [
                        'type' => 'divider',
                        'block_id' => 'divider',
                    ],
                    3 => ResponseBlocks::editTaskButtonBlock(),
                    4 => ResponseBlocks::linkedGitHubBlock(),
                ],
                'submit' => [
                    'type' => 'plain_text',
                    'text' => 'Workday Completed',
                ],
                'close' => [
                    'type' => 'plain_text',
                    'text' => 'Close',
                ],
            ],
        ];
    }
}
