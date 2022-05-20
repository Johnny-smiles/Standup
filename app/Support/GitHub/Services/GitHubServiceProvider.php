<?php

namespace App\Support\GitHub\Services;

use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('github-gateway', function () {
            return new GitHubGateway();
        });
    }

    public function provides()
    {
        return ['github-gateway'];
    }
}
