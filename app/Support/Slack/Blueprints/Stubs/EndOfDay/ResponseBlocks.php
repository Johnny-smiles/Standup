<?php

namespace App\Support\Slack\Blueprints\Stubs\EndOfDay;

class ResponseBlocks
{
    public static function taskStatusSelect(): array
    {
        return
            [
                'type' => 'actions',
                'block_id' => 'elements_1',
                'elements' => [
                    0 => [
                        'type' => 'static_select',
                        'placeholder' => [
                            'type' => 'plain_text',
                            'text' => 'Time spent on task',
                        ],
                        'action_id' => 'time',
                        'options' => [
                            0 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => '15 mins',
                                ],
                                'value' => '15',
                            ],
                            1 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => '30 mins',
                                ],
                                'value' => '30',
                            ],
                            2 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => '45 mins',
                                ],
                                'value' => '45',
                            ],
                            3 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => '60 mins',
                                ],
                                'value' => '60',
                            ],
                            4 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => '90 mins',
                                ],
                                'value' => '90',
                            ],
                            5 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => '120 mins',
                                ],
                                'value' => '120',
                            ],
                            6 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Half Day',
                                ],
                                'value' => '240',
                            ],
                            7 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Full Day',
                                ],
                                'value' => '480',
                            ],
                        ],
                    ],
                    1 => [
                        'type' => 'static_select',
                        'placeholder' => [
                            'type' => 'plain_text',
                            'text' => 'completed',
                        ],
                        'action_id' => 'status',
                        'options' => [
                            0 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Completed',
                                ],
                                'value' => 'completed',
                            ],
                            1 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'In Progress',
                                ],
                                'value' => 'in_progress',
                            ],
                            2 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Blocked',
                                ],
                                'value' => 'blocked',
                            ],
                            3 => [
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Delete',
                                ],
                                'value' => 'deleted',
                            ],
                        ],
                    ],
                ],
            ];
    }

    public static function editTaskButtonBlock(): array
    {
        return [
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
                    'value' => 'edit_task_button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Edit a task',
                    ],
                ],
            ],
        ];
    }

    public static function unlinkedGitHubBlock(): array
    {
        return [
            'type' => 'actions',
            'block_id' => 'github_block_action',
            'elements' => [
                0 => [
                    'type' => 'button',
                    'action_id' => 'github_oauth_button',
                    'value' => 'github_oauth_button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Link GitHub',
                    ],
                    'url' => 'https://github.com/login/oauth/authorize?client_id='.config('services.github.client_id').'&scope=read:user&redirect_uri='.config('services.slack.landing_page').'/oauth/github/redirect',
                ],
                1 => [
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
        ];
    }

    public static function linkedGitHubBlock(): array
    {
        return [
            'type' => 'actions',
            'block_id' => 'github_block_action',
            'elements' => [
                0 => [
                    'type' => 'static_select',
                    'placeholder' => [
                        'type' => 'plain_text',
                        'text' => 'Assigned GitHub Issues',
                    ],
                    'action_id' => 'github_issues',
                    'options' => [
                        0 => [
                            'text' => [
                                'type' => 'plain_text',
                                'text' => 'PracticeRepo  # 1  Practice issue',
                            ],
                            'value' => 'Practice issue',
                        ],
                        1 => [
                            'text' => [
                                'type' => 'plain_text',
                                'text' => 'PracticeRepo  # 2  Issue number 2',
                            ],
                            'value' => 'Issue number 2',
                        ],
                    ],
                ],
                1 => [
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
        ];
    }
}
