<?php

namespace App\Support\Slack\Blueprints\Stubs\StartOfDay;

use App\Models\Workday;

class DeleteTaskStub
{
    public static function requestFromSlackTwoTasks(Workday $workday): array
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
                        'block_id' => 'input_with_dispatch_task_1',
                    ],
                    1 => [
                        'type' => 'actions',
                        'block_id' => 'remove_block_task_1',
                    ],
                    2 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_2',
                    ],
                    3 => [
                        'type' => 'actions',
                        'block_id' => 'remove_block_task_2',
                    ],
                ],
                'state' => [
                    'values' => [
                        'block_task_0' => [
                            'action_task_0' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                        'block_task_1' => [
                            'action_task_1' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                        'block_task_2' => [
                            'action_task_2' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                    ],
                ],
                'hash' => 'HASH_ID',
            ],
            'actions' => [
                0 => [
                    'action_id' => 'remove_task_button',
                    'value' => 'input_with_dispatch_task_2',
                ],
            ],
        ];
    }

    public static function requestFromSlackTwoOrMoreTasks(Workday $workday): array
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
                    1 => [
                        'type' => 'actions',
                        'block_id' => 'remove_block_task_0',
                    ],
                    2 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_1',
                    ],
                    3 => [
                        'type' => 'actions',
                        'block_id' => 'remove_block_task_1',
                    ],
                    4 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_2',
                    ],
                    5 => [
                        'type' => 'actions',
                        'block_id' => 'remove_block_task_2',
                    ],
                ],
                'state' => [
                    'values' => [
                        'input_with_dispatch_task_0' => [
                            'action_task_0' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                        'input_with_dispatch_task_1' => [
                            'action_task_1' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                        'input_with_dispatch_task_2' => [
                            'action_task_2' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                    ],
                ],
                'hash' => 'HASH_ID',
            ],
            'actions' => [
                0 => [
                    'action_id' => 'remove_task_button',
                    'value' => 'input_with_dispatch_task_2',
                ],
            ],
        ];
    }
}
