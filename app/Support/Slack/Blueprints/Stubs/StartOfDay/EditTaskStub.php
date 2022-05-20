<?php

namespace App\Support\Slack\Blueprints\Stubs\StartOfDay;

use App\Models\Workday;

class EditTaskStub
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
                        'block_id' => 'input_with_dispatch_task_1',
                    ],
                    1 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_2',
                    ],
                    2 => [
                        'type' => 'actions',
                        'block_id' => 'multiple_task_action',
                    ],
                ],
                'state' => [
                    'values' => [
                        'block_task_0' => [
                            'action_task_0' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                        'input_with_dispatch_task_1' => [
                            'action_task_1' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                    ],
                ],
                'hash' => 'HASH_ID',
            ],
            'actions' => [
                0 => [
                    'action_id' => 'edit_task_button',
                    'value' => 'edit_task_button',
                ],
            ],
        ];
    }
}
