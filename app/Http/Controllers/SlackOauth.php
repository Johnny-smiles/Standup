<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SlackOauth extends Controller
{
    public function oAuthCallback(Request $request): View|RedirectResponse
    {
        if (array_key_exists('error', $request->toArray())) {
            return redirect()->to('https://slack.com/oauth/v2/authorize?client_id='.config('services.slack.client_id').'&scope=channels:read,chat:write,commands,chat:write.customize&user_scope=identity.avatar,identity.basic,identity.email,identity.team');
        }

        session()->put('code', $request->code);

        return view('slack.oauth')->with(['header' => 'Please Enter Verification Code']);
    }
}
