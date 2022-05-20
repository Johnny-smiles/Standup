<?php

namespace App\Support\Slack\Blueprints\Stubs\Welcome;

use App\Models\Channel;
use App\Models\User;

class SubmissionStub
{
    public static function requestFromSlack(Channel $channel, User $user): array
    {
        return [
            'payload' => json_encode([
                'type' => 'view_submission',
                'team' => [
                    'id' => $channel->team->team_id,
                ],
                'user' => [
                    'id' => $user->slack_id,
                    'username' => $user->name,
                    'name' => $user->name,
                ],
                'api_app_id' => config('services.slack.app_id'),
                'token' => 'TOKEN_ID',
                'trigger_id' => 'TRIGGER_ID',
                'view' => [
                    'id' => 'ROOT_ID',
                    'team_id' => 'TEAM_ID',
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
                            'block_id' => 'FurD5',
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
                    'root_view_id' => 'ROOT_ID',
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

    public static function messageStructureResponse(Channel $channel, User $user): array
    {
        return [
            'channel' => $channel->slack_channel_id,
            'user' => $user->slack_id,
            'username' => 'Standup',
            'blocks' => [
                0 => [
                    'type' => 'section',
                    'block_id' => '0',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => 'Fantastic '.$user->name.'! Lets get started!',
                    ],
                ],
                1 => [
                    'type' => 'divider',
                    'block_id' => 'divider',
                ],
                2 => [
                    'type' => 'section',
                    'block_id' => '1',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => 'Simply type */standup* again to create your first workday.',
                    ],
                ],
            ],
        ];
    }
}
