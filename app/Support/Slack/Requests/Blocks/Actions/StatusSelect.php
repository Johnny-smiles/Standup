<?php

namespace App\Support\Slack\Requests\Blocks\Actions;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class StatusSelect extends Block implements Renderable
{
    public function render(): array
    {
        return [
            'type' => 'static_select',
            'placeholder' => [
                'type' => 'plain_text',
                'text' => $this->status
                    ? "{$this->status}"
                    : 'Status',
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
        ];
    }
}
