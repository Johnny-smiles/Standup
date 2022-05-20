<?php

namespace App\Support\Slack\Services;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin SlackGateway
 */
class Slack extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'slack-gateway';
    }
}
