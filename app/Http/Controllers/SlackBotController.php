<?php

namespace App\Http\Controllers;

use App\Support\Slack\Requests\SlackRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlackBotController extends Controller
{
    public function __invoke(Request $request): Response
    {
        (new SlackRequest($request->toArray()))->handle();

        return response('');
    }
}
