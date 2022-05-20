<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay;

use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\CancelActionButton;
use App\Support\Slack\Requests\Blocks\Actions\DeleteBlock;
use Illuminate\Support\Collection;

class EditTask
{
    public function __invoke(Collection $blocks): array
    {
        return $blocks->reject(function (array $block) {
            return in_array($block['block_id'], ['single_task_action', 'multiple_task_action', 'github_select', 'github_block_action', 'divider', 'plain_text_block']);
        })
            ->map(function (array $block) {
                return [
                    $block,
                    (new DeleteBlock())
                        ->setId(str_replace('input_with_dispatch_task_', '', $block['block_id']))
                        ->render(),
                ];
            })
            ->flatten(1)
            ->push(
                (new ActionsBlock(
                    (new CancelActionButton())->render()
                ))->render()
            )
            ->toArray();
    }
}
