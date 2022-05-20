<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

class CancelActionButton
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'cancel_action_button',
            'text' => [
                'type' => 'plain_text',
                'text' => 'Cancel',
            ],
        ];
    }
}
