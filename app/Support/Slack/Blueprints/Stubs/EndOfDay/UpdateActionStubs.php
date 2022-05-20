<?php

namespace App\Support\Slack\Blueprints\Stubs\EndOfDay;

use App\Models\Task;

class UpdateActionStubs
{
    public static function requestFromSlack(Task $task): array
    {
        return [
            'payload' => json_encode([
                'type' => 'block_actions',
                'user' => [
                    'id' => $task->user->slack_id,
                    'username' => $task->user->slack_username,
                    'name' => $task->user->name,
                ],
                'api_app_id' => config('services.slack.app_id'),
                'token' => 'TOKEN_ID',
                'container' => [
                    'type' => 'view',
                    'view_id' => 'V02UDNHULAZ',
                ],
                'trigger_id' => 'TRIGGER_ID',
                'team' => [
                    'id' => $task->workday->channel->team->team_id,
                    'domain' => 'econo-6',
                ],
                'enterprise' => null,
                'is_enterprise_install' => false,
                'view' => [
                    'id' => 'V02UDNHULAZ',
                    'team_id' => 'TEAM_ID',
                    'type' => 'modal',
                    'blocks' => [],
                    'private_metadata' => '',
                    'callback_id' => 'modal-identifier',
                    'state' => [],
                    'hash' => 'HASH_ID',
                ],
                'actions' => [
                    0 => [
                        'type' => 'static_select',
                        'action_id' => 'status',
                        'block_id' => 'elements_1',
                        'selected_option' => [
                            'text' => [
                                'type' => 'plain_text',
                                'text' => $task->status,
                                'emoji' => true,
                            ],
                            'value' => $task->status,
                        ],
                        'placeholder' => [
                            'type' => 'plain_text',
                            'text' => $task->status,
                            'emoji' => true,
                        ],
                        'action_ts' => '1642518705.691562',
                    ],
                ],
            ]),
        ];
    }

    public static function responseToSlack(): array
    {
        return [
            'view_id' => 'V02UDNHULAZ',
            'hash' => 'HASH_ID',
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
                                'text' => 'completed',
                            ],
                            1 => [
                                'type' => 'image',
                                'image_url' => config('services.slack.slack_emoji_checkmark'),
                                'alt_text' => '',
                            ],
                        ],
                    ],
                    1 => ResponseBlocks::taskStatusSelect(),
                    2 => ResponseBlocks::editTaskButtonBlock(),
                    3 => ResponseBlocks::unlinkedGitHubBlock(),
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

    public static function responseToSlackWithGitHubIssues(): array
    {
        return [
            'view_id' => 'V02UDNHULAZ',
            'hash' => 'HASH_ID',
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
                                'text' => 'completed',
                            ],
                            1 => [
                                'type' => 'image',
                                'image_url' => config('services.slack.slack_emoji_checkmark'),
                                'alt_text' => '',
                            ],
                        ],
                    ],
                    1 => ResponseBlocks::taskStatusSelect(),
                    2 => ResponseBlocks::editTaskButtonBlock(),
                    3 => ResponseBlocks::linkedGitHubBlock(),
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
