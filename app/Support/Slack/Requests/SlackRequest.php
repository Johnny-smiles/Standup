<?php

namespace App\Support\Slack\Requests;

use App\Support\Slack\Requests\Exceptions\MissingNameException;
use App\Support\Slack\Requests\Exceptions\MissingSlackIdException;
use App\Support\Slack\Requests\Exceptions\MissingTeamIdException;
use App\Support\Slack\Requests\Triggers\Open\TriggerOpen;
use App\Support\Slack\Requests\Triggers\Submit\TriggerSubmit;
use App\Support\Slack\Requests\Triggers\Update\TriggerUpdate;
use Exception;
use Illuminate\Support\Arr;

class SlackRequest
{
    protected SlackDataTransferObject $dto;

    public function __construct(array $request)
    {
        if (array_key_exists('payload', $request)) {
            $request = json_decode($request['payload'], true);
        }

        $this->runGuards($request);

        $this->dto = (new SlackDataTransferObject($request))
            ->setAndUpdateUser()
            ->setTeam()
            ->setWorkday()
            ->setBotToken();
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        if (! array_key_exists('type', $this->dto->getRequest())) {
            app(
                TriggerOpen::class,
                ['dto' => $this->dto]
            )->handleSlackRequest();

            return;
        }
        match ($actionType = $this->dto->getRequest()['type']) {
            'block_actions' => app(
                TriggerUpdate::class,
                ['dto' => $this->dto]
            )->handleSlackRequest(),

            'view_submission' => app(
                TriggerSubmit::class,
                ['dto' => $this->dto]
            )->handleSlackRequest(),
            default => throw new Exception('Invalid action type '.$actionType)
        };
    }

    /**
     * @throws MissingSlackIdException
     * @throws MissingNameException
     * @throws MissingTeamIdException
     */
    private function runGuards($request): void
    {
        if (! Arr::get($request, 'user_id')
            && ! Arr::get($request, 'user.id')) {
            throw new MissingSlackIdException();
        }

        if (! Arr::get($request, 'user_name')
            && ! Arr::get($request, 'user.name')) {
            throw new MissingNameException();
        }

        if (! Arr::get($request, 'team_id')
            && ! Arr::get($request, 'team.id')) {
            throw new MissingTeamIdException();
        }
    }
}
