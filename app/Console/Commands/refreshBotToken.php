<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Support\Slack\Services\Slack;
use Illuminate\Console\Command;

class refreshBotToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:bot_refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Refresh BotToken';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        Team::chunk(20, function ($teams) {
            $teams->each(function (Team $team) {
                $refresh = json_decode(Slack::refresh($team->refresh_token), true);

                $team->update(
                    [
                        'bot_token' => $refresh['access_token'],
                        'refresh_token' => $refresh['refresh_token'],
                    ]
                );
            });
        });
    }
}
