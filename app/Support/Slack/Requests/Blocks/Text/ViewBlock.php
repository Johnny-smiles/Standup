<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Models\Workday;

class ViewBlock
{
    public function render(array $blocks, ?Workday $workday): array
    {
        return [
            'type' => 'modal',
            'callback_id' => 'modal-identifier',
            'title' => [
                'type' => 'plain_text',
                'text' => $workday->completed
                    ? 'Plan for the day'
                    : 'Accomplished today',
            ],
            'blocks' => $blocks,
            'submit' => [
                'type' => 'plain_text',
                'text' => $workday->completed
                    ? 'Submit'
                    : 'Workday Completed',
            ],
            'close' => [
                'type' => 'plain_text',
                'text' => 'Close',
            ],
        ];
    }
}
