<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // update active status and visit count
        $event->user->update([
            'status'=>'online',
            'active'=> true,
            'visits'=>$event->user->visits++,
        ]);
    }
}
