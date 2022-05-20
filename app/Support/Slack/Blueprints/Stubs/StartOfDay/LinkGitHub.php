<?php

namespace App\Support\Slack\Blueprints\Stubs\StartOfDay;

use App\Models\Workday;

class LinkGitHub
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
                        'element' => [
                            'type' => 'plain_text_input',
                            'action_id' => 'additional_task',
                            'placeholder' => [
                                'type' => 'plain_text',
                                'text' => 'Write something',
                            ],
                        ],
                    ],
                    1 => [
                        'type' => 'input',
                        'block_id' => 'input_with_dispatch_task_2',
                        'element' => [
                            'type' => 'plain_text_input',
                            'action_id' => 'additional_task',
                            'placeholder' => [
                                'type' => 'plain_text',
                                'text' => 'Write something',
                            ],
                        ],
                    ],
                    2 => [
                        'type' => 'divider',
                        'block_id' => 'divider',
                    ],
                    3 => [
                        'type' => 'actions',
                        'block_id' => 'multiple_task_action',
                        'elements' => [
                            0 => [
                                'type' => 'button',
                                'action_id' => 'add_task_button',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Add another task',
                                ],
                            ],
                            1 => [
                                'type' => 'button',
                                'action_id' => 'edit_task_button',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Edit a task',
                                ],
                                'value' => 'edit_task_button',
                            ],
                        ],
                    ],
                    4 => [
                        'type' => 'actions',
                        'block_id' => 'github_block_action',
                        'elements' => [
                            0 => [
                                'type' => 'button',
                                'action_id' => 'github_oauth_button',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Link GitHub',
                                ],
                                'value' => 'github_oauth_button',
                                'url' => 'https://github.com/login/oauth/authorize?client_id='.config('services.github.client_id').'&scope=read:user&redirect_uri='.config('services.slack.landing_page').'/oauth/github/redirect',
                            ],
                            1 => [
                                'type' => 'button',
                                'action_id' => 'standup_url',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Standup Dashboard',
                                ],
                                'value' => 'standup_dashboard',
                                'url' => config('services.slack.landing_page'),                                            ],
                        ],
                    ],
                ],
                'state' => [
                    'values' => [
                        'input_with_dispatch_task_1' => [
                            'additional_task' => [
                                'type' => 'plain_text_input',
                                'value' => 'Hello world',
                            ],
                        ],
                        'input_with_dispatch_task_2' => [
                            'additional_task' => [
                                'type' => 'plain_text_input',
                            ],
                        ],
                    ],
                ],
                'hash' => 'HASH_ID',
            ],
            'actions' => [
                0 => [
                    'action_id' => 'github_oauth_button',
                    'value' => 'github_oauth_button',
                ],
            ],
        ];
    }
}
