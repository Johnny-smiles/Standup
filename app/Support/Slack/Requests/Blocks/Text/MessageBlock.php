<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Models\User;

class MessageBlock
{
    public function render(array $blocks, string $channelId, User $user): array
    {
        return [
            'channel' => $channelId,
            'username' => $user->name ?? $user->slack_username,
            'icon_url' => $user->avatar ?? config('services.slack.slack_message_response_icon'),
            'blocks' => $blocks,
        ];
    }
}
