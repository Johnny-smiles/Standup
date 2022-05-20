<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Renderable;

class ZaengleMessageBlock implements Renderable
{
    public function render(): array
    {
        return  [
            'type' => 'context',
            'elements' => [
                [
                    'type' => 'mrkdwn',
                    'text' => 'Empowered by: *Zaengle*',
                ],
                [
                    'type' => 'mrkdwn',
                    'text' => '*Be Nice, Do Good*',
                ],
                [
                    'type' => 'image',
                    'image_url' => config('services.slack.slack_message_response_icon'),
                    'alt_text' => 'images',
                ],
            ],
        ];
    }
}
