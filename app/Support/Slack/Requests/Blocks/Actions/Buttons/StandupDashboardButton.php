<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class StandupDashboardButton extends Block implements Renderable
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'standup_url',
            'value' => 'standup_dashboard',
            'text' => [
                'type' => 'plain_text',
                'text' => 'Standup Dashboard',
            ],
            'url' => config('services.slack.landing_page'),
        ];
    }
}
