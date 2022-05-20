<?php

namespace App\Support\Slack\Requests\Triggers\Submit\Views;

use App\Support\Slack\Requests\Blocks\Text\DividerBlock;
use App\Support\Slack\Requests\Blocks\Text\MarkdownTextBlock;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\ModalSubmit;
use App\Support\Slack\Requests\Triggers\Submit\SubmissionActions\Persist;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class WelcomeView extends ModalSubmit implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        (new Persist())->handle($dto);

        $dto->getUser()->workdays()->latest()->first()->update(['completed' => true]);

        return $this->respond(
            $this->blocks
                ->push((new MarkdownTextBlock())
                    ->setText("Fantastic {$this->getName()}! Lets get started!")
                    ->setId(0)
                    ->render()
                )
                ->push((new DividerBlock())->render())
                ->push((new MarkdownTextBlock())
                    ->setText('Simply type */standup* again to create your first workday.')
                    ->setId(1)
                    ->render()
                )
                ->toArray()
        );
    }
}
