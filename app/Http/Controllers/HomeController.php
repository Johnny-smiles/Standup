<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('pages.home', [
            'user' => $user,
            'tasks' => $user->tasks,
            'completedTasks' => $user->tasks->where('status', '=', 'completed'),
            'blockedTasks' => $user->tasks->where('status', '=', 'blocked'),
            'inProgressTasks' => $user->tasks->where('status', '=', 'in_progress'),
            'deletedTasks' => $user->tasks->where('status', '=', 'deleted'),
        ]);
    }

    public function alert(Request $request): View
    {
        return view('pages.alert', [
            'alert' => $request['message'],
            'action' => $request['action'],
        ]);
    }
}
