<?php

namespace App\Support\Slack\Requests\Triggers\Update;

use App\Support\Slack\Requests\Blocks\Text\ViewBlock;
use App\Support\Slack\Requests\Blocks\Text\WelcomeViewBlock;
use App\Support\Slack\Requests\Exceptions\MissingHashException;
use App\Support\Slack\Requests\Exceptions\MissingViewIdException;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class ModalUpdate
{
    protected SlackDataTransferObject $dto;
    protected int $taskCount;
    protected Collection $blocks;
    protected string $viewId;
    protected string $hash;
    protected string $actionType;
    protected ?string $taskValue;
    protected ?string $actionValue;
    protected ?string $taskId;
    protected ?bool $inputBlock;

    protected function extractGlobals(SlackDataTransferObject $dto): void
    {
        $this->runGuards($dto->getRequest());

        $this->dto = $dto;

        $this->taskCount = $this->taskCount();

        $this->blocks = ! $dto->getWorkday() || $dto->getWorkday()->completed
            ? collect($dto->getRequest()['view']['blocks'])
            : Collection::empty();

        $this->viewId = $dto->getRequest()['view']['id'];

        $this->hash = $dto->getRequest()['view']['hash'];

        $this->actionType = Arr::get($dto->getRequest(), 'actions.0.action_id');

        $this->actionValue = Arr::get($dto->getRequest(), 'actions.0.selected_option.value');

        $this->taskValue = Arr::get($dto->getRequest(), 'actions.0.value');

        $this->taskId = preg_replace(
            '/[^0-9]/',
            '',
            Arr::get($dto->getRequest(),
                'actions.0.block_id')
        );
    }

    protected function taskCount()
    {
        return substr_count(json_encode(Arr::get($this->dto->getRequest(), 'view.state.values')), 'input_with_dispatch_task_');
    }

    protected function respond(array $blocks): array
    {
        return  [
            'view_id' => $this->viewId,
            'hash' => $this->hash,
            'view' => $this->dto->getWorkday()
                ? (new ViewBlock())->render($blocks, $this->dto->getWorkday())
                : (new WelcomeViewBlock())->render($blocks),
        ];
    }

    /**
     * @throws MissingViewIdException
     * @throws MissingHashException
     */
    private function runGuards(array $request): void
    {
        if (! Arr::get($request, 'view.id')) {
            throw new MissingViewIdException();
        }

        if (! Arr::get($request, 'view.hash')) {
            throw new MissingHashException();
        }
    }
}
