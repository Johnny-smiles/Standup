<?php

namespace App\Support\Slack\Requests\Blocks\Actions;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class TimeSelect extends Block implements Renderable
{
    public function render(): array
    {
        $return = [
            'type' => 'static_select',
            'placeholder' => [
                'type' => 'plain_text',
                'text' => $this->time
                    ? "{$this->time}"
                    : 'Time spent on task',
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
        ];

        return $return;
    }
}
