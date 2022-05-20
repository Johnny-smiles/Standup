<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class GitHubOauthButton extends Block implements Renderable
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'github_oauth_button',
            'value' => 'github_oauth_button',
            'text' => [
                'type' => 'plain_text',
                'text' => 'Link GitHub',
            ],
            'url' => config('services.github.base_auth_route').'?client_id='.config('services.github.client_id').'&scope=read:user&redirect_uri='.config('services.github.redirect'),
        ];
    }
}
