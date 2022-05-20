<?php

namespace App\Support\Slack\Requests\Triggers\Submit;

use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\Views\EndOfDayView;
use App\Support\Slack\Requests\Triggers\Submit\Views\StartOfDayView;
use App\Support\Slack\Requests\Triggers\Submit\Views\WelcomeView;
use App\Support\Slack\Services\Slack;

class TriggerSubmit
{
    public function __construct(public SlackDataTransferObject $dto)
    {
    }

    public function handleSlackRequest(): void
    {
        $view = EndOfDayView::class;

        if (! $this->dto->getWorkday()) {
            Slack::postEphemeralMessage(
                app(WelcomeView::class)->buildResponse($this->dto),
                $this->dto->getBotToken()
            );

            return;
        } elseif ($this->dto->getWorkday()->completed) {
            $view = StartOfDayView::class;
        }

        $this->postMessage($view);
    }

    private function postMessage(string $view): void
    {
        Slack::postMessage(
            app($view)->buildResponse($this->dto),
            $this->dto->getBotToken()
        );
    }
}
