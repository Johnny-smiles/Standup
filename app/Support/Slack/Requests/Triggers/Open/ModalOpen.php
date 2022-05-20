<?php

namespace App\Support\Slack\Requests\Triggers\Open;

use App\Models\Channel;
use App\Support\GitHub\Services\GitHub;
use App\Support\Slack\Requests\Blocks\Text\ViewBlock;
use App\Support\Slack\Requests\Blocks\Text\WelcomeViewBlock;
use App\Support\Slack\Requests\Exceptions\MissingChannelIdException;
use App\Support\Slack\Requests\Exceptions\MissingTriggerIdException;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

abstract class ModalOpen
{
    protected Collection $blocks;
    protected Channel $channel;
    protected string $trigger_id;

    protected function extractGlobals(SlackDataTransferObject $dto): void
    {
        $this->runGuards($dto->getRequest());

        $this->dto = $dto;

        $this->dto->getUser()->is_admin
            ? $this->channel = $this->channelUpdate()
            : $this->channel = $this->dto->getTeam()->channel;

        $this->trigger_id = $dto->getRequest()['trigger_id'];

        $this->blocks = Collection::empty();

        if ($dto->getUser()->github_token) {
            $this->cacheGitHubIssues();
        }
    }

    protected function channelUpdate(): Channel
    {
        $this->dto->getTeam()->channel->update(
            [
                'slack_channel_id' => $this->dto->getRequest()['channel_id'],
                'name' => $this->dto->getRequest()['channel_name'],
            ]
        );

        return $this->channel = $this->dto->getTeam()->channel;
    }

    protected function respond(array $blocks): array
    {
        return [
            'channel' => $this->channel->slack_channel_id,
            'trigger_id' => $this->trigger_id,
            'view' => $this->dto->getWorkday()
                ? (new ViewBlock())->render($blocks, $this->dto->getWorkday())
                : (new WelcomeViewBlock())->render($blocks),
        ];
    }

    /**
     * @throws MissingTriggerIdException
     * @throws MissingChannelIdException
     */
    private function runGuards(array $request): void
    {
        if (! array_key_exists('trigger_id', $request)) {
            throw new MissingTriggerIdException();
        }
        if (! array_key_exists('channel_id', $request)) {
            throw new MissingChannelIdException();
        }
    }

    protected function cacheGitHubIssues()
    {
        $issues = json_decode(
            GitHub::githubIssuesQuery(
                [
                    'number_of_issues' => 5,
                    'state' => 'OPEN',
                ],
                $this->dto->getUser()->github_token
            ),
            true
        )
        ['data']['viewer']['issues']['nodes'];

        Cache::put($this->dto->getUser()->getKey().'.github-issues', $issues);
    }
}
