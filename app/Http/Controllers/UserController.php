<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __invoke(): View
    {
        $users = Collection::empty();

        auth()->user()->teams()->get()
            ->each(function ($team) use (&$users) {
                $users->push(
                    $team->users->map->only(['name', 'email', 'status'])
                );
            });

        return view('pages.users', [
            'users' => $users->flatten(1)->toArray(),
        ]);
    }
}
