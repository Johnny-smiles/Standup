<?php

namespace App\Support\GitHub\Services;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin GitHubGateway
 */
class GitHub extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'github-gateway';
    }
}
