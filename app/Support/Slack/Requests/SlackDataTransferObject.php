<?php

namespace App\Support\Slack\Requests;

use App\Models\Team;
use App\Models\User;
use App\Models\Workday;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SlackDataTransferObject
{
    private array $request;
    private User $user;
    private Team $team;
    private string $botToken;
    private Collection $taskText;
    private Workday|null $workday;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function setAndUpdateUser(): self
    {
        $this->user = User::updateOrCreate(
            ['slack_id' => $this->request['user_id'] ?? $this->request['user']['id']],
            ['slack_username' => $this->request['user_name'] ?? $this->request['user']['name']]
        );

        return $this;
    }

    public function setTeam(): self
    {
        $this->team = Team::where(['team_id' => $this->request['team_id']
            ?? $this->request['team']['id'], ])->first();

        return $this;
    }

    public function setWorkday(): self
    {
        $this->workday = $this->user->workdays()->latest('id')->first();

        return $this;
    }

    public function setBotToken(): self
    {
        $this->botToken = $this->team->bot_token;

        return $this;
    }

    public function setTaskText(): self
    {
        $tasks = $this->request['view']['state']['values'];

        unset($tasks['github_block_action']);

        $this->taskText = str_contains(array_key_first($tasks), 'input_with_dispatch_task')
            ? collect($tasks)->values()->map(function ($task) {
                return (collect($task)->values()->toArray())[0]['value'];
            })
            : collect('Welcome!');

        return $this;
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getWorkday(): Workday|null
    {
        return $this->workday;
    }

    public function getBotToken(): string
    {
        return $this->botToken;
    }

    public function getTaskText(): Collection
    {
        return $this->taskText;
    }

    public function getGitHubIssues(): array|null
    {
        return Cache::get($this->user->getKey().'.github-issues');
    }
}
