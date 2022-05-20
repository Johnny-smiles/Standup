<?php

namespace App\Support\Slack\Blueprints\Stubs\EndOfDay;

use App\Models\Task;

class SubmissionStub
{
    public static function requestFromSlack(Task $task): array
    {
        return [
            'payload' => json_encode([
                'type' => 'view_submission',
                'user' => [
                    'id' => $task->workday->user->slack_id,
                    'username' => $task->workday->user->name,
                    'name' => $task->workday->user->name,
                ],
                'trigger_id' => 'TRIGGER_ID',
                'team' => [
                    'id' => $task->workday->channel->team->team_id,
                ],
                'api_app_id' => config('services.slack.app_id'),
                'token' => 'TOKEN_ID',
                'view' => [
                    'id' => 'VIEW_ID',
                    'type' => 'modal',
                    'blocks' => [
                        0 => [
                            'type' => 'context',
                            'block_id' => 'task_348',
                            'elements' => [
                                0 => [
                                    'type' => 'mrkdwn',
                                    'text' => 'completed',
                                    'verbatim' => false,
                                ],
                                1 => [
                                    'type' => 'mrkdwn',
                                    'text' => '15 mins',
                                    'verbatim' => false,
                                ],
                                2 => [
                                    'type' => 'image',
                                    'image_url' => config('services.slack.slack_emoji_checkmark'),
                                    'alt_text' => '',
                                ],
                            ],
                        ],
                        1 => [
                            'type' => 'actions',
                            'block_id' => 'elements_348',
                            'elements' => [
                                0 => [
                                    'type' => 'static_select',
                                    'action_id' => 'time',
                                    'placeholder' => [
                                        'type' => 'plain_text',
                                        'text' => '15',
                                        'emoji' => true,
                                    ],
                                    'options' => [
                                        0 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => '15 mins',
                                                'emoji' => true,
                                            ],
                                            'value' => '15',
                                        ],
                                        1 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => '30 mins',
                                                'emoji' => true,
                                            ],
                                            'value' => '30',
                                        ],
                                        2 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => '45 mins',
                                                'emoji' => true,
                                            ],
                                            'value' => '45',
                                        ],
                                        3 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => '60 mins',
                                                'emoji' => true,
                                            ],
                                            'value' => '60',
                                        ],
                                        4 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => '90 mins',
                                                'emoji' => true,
                                            ],
                                            'value' => '90',
                                        ],
                                        5 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => '120 mins',
                                                'emoji' => true,
                                            ],
                                            'value' => '120',
                                        ],
                                        6 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => 'Half Day',
                                                'emoji' => true,
                                            ],
                                            'value' => '240',
                                        ],
                                        7 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => 'Full Day',
                                                'emoji' => true,
                                            ],
                                            'value' => '480',
                                        ],
                                    ],
                                ],
                                1 => [
                                    'type' => 'static_select',
                                    'action_id' => 'status',
                                    'placeholder' => [
                                        'type' => 'plain_text',
                                        'text' => 'completed',
                                        'emoji' => true,
                                    ],
                                    'options' => [
                                        0 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => 'Completed',
                                                'emoji' => true,
                                            ],
                                            'value' => 'completed',
                                        ],
                                        1 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => 'In Progress',
                                                'emoji' => true,
                                            ],
                                            'value' => 'in_progress',
                                        ],
                                        2 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => 'Blocked',
                                                'emoji' => true,
                                            ],
                                            'value' => 'blocked',
                                        ],
                                        3 => [
                                            'text' => [
                                                'type' => 'plain_text',
                                                'text' => 'Delete',
                                                'emoji' => true,
                                            ],
                                            'value' => 'deleted',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        2 => [
                            'type' => 'actions',
                            'block_id' => 'single_task_action',
                            'elements' => [
                                0 => [
                                    'type' => 'button',
                                    'action_id' => 'add_task_button',
                                    'text' => [
                                        'type' => 'plain_text',
                                        'text' => 'Add another task',
                                        'emoji' => true,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'private_metadata' => '',
                    'callback_id' => 'modal-identifier',
                    'state' => [
                        'values' => [
                            'elements_348' => [
                                'time' => [
                                    'type' => 'static_select',
                                    'selected_option' => [
                                        'text' => [
                                            'type' => 'plain_text',
                                            'text' => '15 mins',
                                            'emoji' => true,
                                        ],
                                        'value' => '15',
                                    ],
                                ],
                                'status' => [
                                    'type' => 'static_select',
                                    'selected_option' => [
                                        'text' => [
                                            'type' => 'plain_text',
                                            'text' => 'Completed',
                                            'emoji' => true,
                                        ],
                                        'value' => 'completed',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'hash' => '1643062782.9qTWzBSF',
                    'title' => [
                        'type' => 'plain_text',
                        'text' => 'Accomplished today',
                        'emoji' => true,
                    ],
                    'clear_on_close' => false,
                    'notify_on_close' => false,
                    'close' => [
                        'type' => 'plain_text',
                        'text' => 'Close',
                        'emoji' => true,
                    ],
                    'submit' => [
                        'type' => 'plain_text',
                        'text' => 'Workday Completed',
                        'emoji' => true,
                    ],
                    'previous_view_id' => null,
                    'root_view_id' => 'VIEW_ID',
                    'app_id' => config('services.slack.app_id'),
                    'external_id' => '',
                    'app_installed_team_id' => 'TEAM_ID',
                    'bot_id' => 'BOT_ID',
                ],
                'response_urls' => [
                ],
                'is_enterprise_install' => false,
                'enterprise' => null,
            ]),
        ];
    }

    public static function messageStructureResponse(Task $task): array
    {
        return [
            'channel' => $task->workday->channel->slack_channel_id,
            'username' => $task->workday->user->name,
            'icon_url' => config('services.slack.slack_message_response_icon'),
            'blocks' => [
                0 => [
                    'type' => 'section',
                    'block_id' => 'plain_text_block',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Today:
• completed ✅
',
                        'emoji' => true,
                    ],
                ],
                1 => [
                    'type' => 'context',
                    'elements' => [
                        0 => [
                            'type' => 'mrkdwn',
                            'text' => 'Empowered by: *Zaengle*',
                        ],
                        1 => [
                            'type' => 'mrkdwn',
                            'text' => '*Be Nice, Do Good*',
                        ],
                        2 => [
                            'type' => 'image',
                            'image_url' => config('services.slack.slack_message_response_icon'),
                            'alt_text' => 'images',
                        ],
                    ],
                ],
            ],
        ];
    }
}
