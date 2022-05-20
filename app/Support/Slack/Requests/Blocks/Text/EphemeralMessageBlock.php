<?php

namespace App\Support\Slack\Requests\Blocks\Text;

class EphemeralMessageBlock
{
    public function render(array $blocks, string $channelId, string $userSlackId): array
    {
        return [
            'channel' => $channelId,
            'user' => $userSlackId,
            'username' => 'Standup',
            'blocks' => $blocks,
        ];
    }
}
