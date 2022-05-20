<?php

namespace App\Support\Slack\Requests\Triggers\Update;

use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\Views\EndOfDayView;
use App\Support\Slack\Requests\Triggers\Update\Views\StartOfDayView;
use App\Support\Slack\Requests\Triggers\Update\Views\WelcomeView;
use App\Support\Slack\Services\Slack;

class TriggerUpdate
{
    public function __construct(public SlackDataTransferObject $dto)
    {
    }

    public function handleSlackRequest(): void
    {
        $view = EndOfDayView::class;

        if (! $this->dto->getWorkday()) {
            $view = WelcomeView::class;
        } elseif ($this->dto->getWorkday()->completed) {
            $view = StartOfDayView::class;
        }

        $this->updateModal($view);
    }

    private function updateModal(string $view): void
    {
        Slack::updateModal(
            app($view)->buildResponse($this->dto),
            $this->dto->getBotToken()
        );
    }
}
