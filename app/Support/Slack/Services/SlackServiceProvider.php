<?php

namespace App\Support\Slack\Services;

use Illuminate\Support\ServiceProvider;

class SlackServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('slack-gateway', function () {
            return new SlackGateway();
        });
    }

    public function provides()
    {
        return ['slack-gateway'];
    }
}
