<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ToggleActivityController extends Controller
{
    public function __invoke($status): RedirectResponse
    {
        Auth::user()->update(['status' => $status]);

        return back();
    }
}
