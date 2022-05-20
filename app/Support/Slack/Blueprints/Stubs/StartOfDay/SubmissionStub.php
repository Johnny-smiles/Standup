<?php

namespace App\Support\Slack\Blueprints\Stubs\StartOfDay;

use App\Models\Workday;

class SubmissionStub
{
    public static function requestFromSlack(Workday $workday): array
    {
        return [
            'payload' => json_encode([
                'type' => 'view_submission',
                'user' => [
                    'id' => $workday->user->slack_id,
                    'username' => $workday->user->name,
                    'name' => $workday->user->name,
                ],
                'trigger_id' => 'TRIGGER_ID',
                'team' => [
                    'id' => $workday->channel->team->team_id,
                ],
                'view' => [
                    'id' => 'VIEW_ID',
                    'state' => [
                        'values' => [
                            'input_with_dispatch_task_1' => [
                                'action_task_0' => [
                                    'type' => 'plain_text_input',
                                    'value' => 'Hello world',
                                ],
                            ],
                            'input_with_dispatch_task_2' => [
                                'action_task_1' => [
                                    'type' => 'plain_text_input',
                                    'value' => 'Its a beautiful day',
                                ],
                            ],
                            'input_with_dispatch_task_3' => [
                                'action_task_2' => [
                                    'type' => 'plain_text_input',
                                    'value' => 'Lets explore',
                                ],
                            ],
                        ],
                    ],
                    'hash' => 'HASH_ID',
                ],
            ]),
        ];
    }

    public static function messageStructureResponse(Workday $workday): array
    {
        return [
            'channel' => $workday->channel->slack_channel_id,
            'username' => $workday->user->name,
            'icon_url' => config('services.slack.slack_message_response_icon'),
            'blocks' => [
                0 => [
                    'type' => 'section',
                    'block_id' => 'plain_text_block',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Today:
• Hello world
• Its a beautiful day
• Lets explore
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
