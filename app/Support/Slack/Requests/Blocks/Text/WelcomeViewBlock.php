<?php

namespace App\Support\Slack\Requests\Blocks\Text;

class WelcomeViewBlock
{
    public function render(array $blocks): array
    {
        return [
            'type' => 'modal',
            'callback_id' => 'modal-identifier',
            'title' => [
                'type' => 'plain_text',
                'text' => 'Welcome!',
            ],
            'blocks' => $blocks,
            'submit' => [
                'type' => 'plain_text',
                'text' => 'Create first Workday',
            ],
        ];
    }
}
