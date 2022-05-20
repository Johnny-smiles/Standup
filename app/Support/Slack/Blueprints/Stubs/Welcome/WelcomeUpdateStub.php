<?php

namespace App\Support\Slack\Blueprints\Stubs\Welcome;

use App\Models\Channel;
use App\Models\User;

class WelcomeUpdateStub
{
    public static function requestFromSlack(Channel $channel, User $user): array
    {
        return [
            'type' => 'block_actions',
            'user' => [
                'id' => $user->slack_id,
                'username' => $user->name,
                'name' => $user->name,
            ],
            'trigger_id' => 'TRIGGER_CODE_64488ed92b33d59364fb5c09cd351be4',
            'team' => [
                'id' => $channel->team->team_id,
            ],
            'view' => [
                'id' => 'VIEW_ID',
                'team_id' => 'T027HN45LKD',
                'type' => 'modal',
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
                        'block_id' => 'Ec29',
                        'image_url' => config('services.slack.slack_inspirational'),
                        'alt_text' => 'Inspirational',
                        'fallback' => '1024x512px image',
                        'image_width' => 1024,
                        'image_height' => 512,
                        'image_bytes' => 63104,
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
                            'verbatim' => false,
                        ],
                        'accessory' => [
                            'type' => 'button',
                            'action_id' => 'standup_url',
                            'text' => [
                                'type' => 'plain_text',
                                'text' => 'Standup Dashboard',
                                'emoji' => true,
                            ],
                            'value' => 'standup_dashboard',
                            'url' => config('services.slack.landing_page'),
                        ],
                    ],
                ],
                'private_metadata' => '',
                'callback_id' => 'modal-identifier',
                'state' => [
                    'values' => [
                    ],
                ],
                'hash' => 'HASH_ID',
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Welcome!',
                    'emoji' => true,
                ],
                'clear_on_close' => false,
                'notify_on_close' => false,
                'close' => null,
                'submit' => [
                    'type' => 'plain_text',
                    'text' => 'Create first Workday',
                    'emoji' => true,
                ],
                'previous_view_id' => null,
                'root_view_id' => 'VIEW_ID',
                'app_id' => config('services.slack.app_id'),
                'external_id' => '',
                'app_installed_team_id' => 'T027HN45LKD',
                'bot_id' => 'B027E9GSKLHL',
            ],
            'actions' => [
                0 => [
                    'action_id' => 'standup_url',
                    'block_id' => '0',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Standup Dashboard',
                        'emoji' => true,
                    ],
                    'value' => 'standup_dashboard',
                    'type' => 'button',
                    'action_ts' => '1634153582.971416',
                ],
            ],
        ];
    }

    public static function responseToSlack(Channel $channel, User $user): array
    {
        return [
            'view_id' => 'VIEW_ID',
            'hash' => 'HASH_ID',
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
                            'emoji' => '1',
                        ],
                    ],
                    1 => [
                        'type' => 'image',
                        'image_url' => config('services.slack.slack_thumbs_up'),
                        'alt_text' => 'ThumbsUp',
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
                            'verbatim' => '0',
                        ],
                        'accessory' => [
                            'type' => 'button',
                            'action_id' => 'standup_url',
                            'text' => [
                                'type' => 'plain_text',
                                'text' => 'Standup Dashboard',
                                'emoji' => '1',
                            ],
                            'value' => 'standup_dashboard',
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
