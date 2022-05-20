<?php

namespace App\Support\Slack\Blueprints\Stubs\Welcome;

use App\Models\Channel;
use App\Models\User;

class ModalTriggerStub
{
    public static function requestWelcomeFromSlack(Channel $channel, User $user): array
    {
        return [
            'team_id' => $channel->team->team_id,
            'channel_id' => $channel->slack_channel_id,
            'channel_name' => $channel->name,
            'user_id' => $user->slack_id,
            'user_name' => $user->name,
            'trigger_id' => 'TRIGGER_ID',
        ];
    }

    public static function responseWelcomeToSlack(Channel $channel, User $user): array
    {
        return [
            'channel' => $channel->slack_channel_id,
            'trigger_id' => 'TRIGGER_ID',
            'view' => [
                'type' => 'modal',
                'callback_id' => 'modal-identifier',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Welcome!',
                ],
                'blocks' => [
                    0 => [
                        'type' => 'header',
                        'block_id' => 'welcome',
                        'text' => [
                            'type' => 'plain_text',
                            'text' => 'Welcome to Standups '.$user->name.'!',
                            'emoji' => true,
                        ],
                    ],
                    1 => [
                        'type' => 'image',
                        'image_url' => config('services.slack.slack_inspirational'),
                        'alt_text' => 'Inspirational',
                    ],
                    2 => [
                        'type' => 'divider',
                        'block_id' => 'divider',
                    ],
                    3 => [
                        'type' => 'section',
                        'block_id' => '0',
                        'text' => [
                            'type' => 'mrkdwn',
                            'text' => 'Click this button to allow *Standup* to post with your name and avatar.',
                        ],
                        'accessory' => [
                            'type' => 'button',
                            'action_id' => 'standup_url',
                            'value' => 'standup_dashboard',
                            'text' => [
                                'type' => 'plain_text',
                                'text' => 'Standup Dashboard',
                            ],
                            'url' => config('services.slack.landing_page'),
                        ],
                    ],
                ],
                'submit' => [
                    'type' => 'plain_text',
                    'text' => 'Create first Workday',
                ],
            ],
        ];
    }
}
