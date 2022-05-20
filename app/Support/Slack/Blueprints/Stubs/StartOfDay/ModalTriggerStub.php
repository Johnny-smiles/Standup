<?php

namespace App\Support\Slack\Blueprints\Stubs\StartOfDay;

use App\Models\Workday;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\ResponseBlocks;

class ModalTriggerStub
{
    public static function requestStartOfDayFromSlack(Workday $workday): array
    {
        return [
            'team_id' => $workday->channel->team->team_id,
            'channel_id' => $workday->channel->slack_channel_id,
            'channel_name' => $workday->channel->name,
            'user_id' => $workday->user->slack_id,
            'user_name' => $workday->user->name,
            'trigger_id' => 'TRIGGER_ID',
        ];
    }

    public static function responseStartOfDayToSlack(Workday $workday): array
    {
        return [
            'channel' => $workday->channel->slack_channel_id,
            'trigger_id' => 'TRIGGER_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Plan for the day',
                ],
                'blocks' => [
                    0 => [
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
                    1 => [
                        'type' => 'actions',
                        'block_id' => 'single_task_action',
                        'elements' => [
                            0 => [
                                'type' => 'button',
                                'action_id' => 'add_task_button',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Add another task',
                                ],
                            ],
                        ],
                    ],
                    2 => ResponseBlocks::unlinkedGitHubBlock(),
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

    public static function responseStartOfDayToSlackWithGitHubIssues(Workday $workday): array
    {
        return [
            'channel' => $workday->channel->slack_channel_id,
            'trigger_id' => 'TRIGGER_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Plan for the day',
                ],
                'blocks' => [
                    0 => [
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
                    1 => [
                        'type' => 'actions',
                        'block_id' => 'single_task_action',
                        'elements' => [
                            0 => [
                                'type' => 'button',
                                'action_id' => 'add_task_button',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Add another task',
                                ],
                            ],
                        ],
                    ],
                    2 => ResponseBlocks::linkedGitHubBlock(),
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
