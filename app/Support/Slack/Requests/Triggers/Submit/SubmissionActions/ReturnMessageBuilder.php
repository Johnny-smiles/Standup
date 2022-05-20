<?php

namespace App\Support\Slack\Requests\Triggers\Submit\SubmissionActions;

use App\Support\Slack\Requests\Blocks\Text\PlainTextBlock;
use App\Support\Slack\Requests\Blocks\Text\ZaengleMessageBlock;

class ReturnMessageBuilder
{
    public function handle(string $messageText): array
    {
        return [
            (new PlainTextBlock())->setText($messageText)->render(),
            (new ZaengleMessageBlock())->render(),
        ];
    }
}
