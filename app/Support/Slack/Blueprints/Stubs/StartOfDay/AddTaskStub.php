<?php

namespace App\Support\Slack\Blueprints\Stubs\StartOfDay;

use App\Models\Workday;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\ResponseBlocks;

class AddTaskStub
{
    public static function requestFromSlack(Workday $workday): array
    {
        return [
            'type' => 'block_actions',
            'user' => [
                'id' => $workday->user->slack_id,
                'username' => $workday->user->name,
                'name' => $workday->user->name,
            ],
            'trigger_id' => 'TRIGGER_CODE_64488ed92b33d59364fb5c09cd351be4',
            'team' => [
                'id' => $workday->channel->team->team_id,
            ],
            'view' => [
                'id' => 'VIEW_ID',
                'blocks' => [
                    0 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_0',
                    ],
                ],
                'state' => [
                    'values' => [
                        'block_task_0' => [
                            'action_task_0' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                    ],
                ],
                'hash' => 'HASH_ID',
            ],
            'actions' => [
                0 => [
                    'action_id' => 'add_task_button',
                ],
            ],
        ];
    }

    public static function responseToSlack(): array
    {
        return [
            'view_id' => 'VIEW_ID',
            'hash' => 'HASH_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Plan for the day',
                ],
                'blocks' => [
                    0 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_0',
                    ],
                    1 => [
                        'dispatch_action' => true,
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_1',
                        'element' => [
                            'type' => 'plain_text_input',
                            'action_id' => 'additional_task',
                            'initial_value' => '',
                            'placeholder' => [
                                'type' => 'plain_text',
                                'text' => 'Write something',
                            ],
                        ],
                        'label' => [
                            'type' => 'plain_text',
                            'text' => 'Task:',
                            'emoji' => true,
                        ],
                    ],
                    2 => [
                        'type' => 'divider',
                        'block_id' => 'divider',
                    ],
                    3 => ResponseBlocks::editTaskButtonBlock(),
                    4 => ResponseBlocks::unlinkedGitHubBlock(),
                ],
                'submit' => [
                    'type' => 'plain_text',
                    'text' => 'Submit',
                ],
                'close' => [
                    'type' => 'plain_text',
                    'text' => 'Close',
                ],
            ],
        ];
    }

    public static function responseToSlackWithGitHubIssue(): array
    {
        return [
            'view_id' => 'VIEW_ID',
            'hash' => 'HASH_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Plan for the day',
                ],
                'blocks' => [
                    0 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_0',
                    ],
                    1 => [
                        'dispatch_action' => true,
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_1',
                        'element' => [
                            'type' => 'plain_text_input',
                            'action_id' => 'additional_task',
                            'initial_value' => '',
                            'placeholder' => [
                                'type' => 'plain_text',
                                'text' => 'Write something',
                            ],
                        ],
                        'label' => [
                            'type' => 'plain_text',
                            'text' => 'Task:',
                            'emoji' => true,
                        ],
                    ],
                    2 => [
                        'type' => 'divider',
                        'block_id' => 'divider',
                    ],
                    3 => ResponseBlocks::editTaskButtonBlock(),
                    4 => ResponseBlocks::linkedGitHubBlock(),
                ],
                'submit' => [
                    'type' => 'plain_text',
                    'text' => 'Submit',
                ],
                'close' => [
                    'type' => 'plain_text',
                    'text' => 'Close',
                ],
            ],
        ];
    }
}
