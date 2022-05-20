<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteWorkdayRequest;
use App\Models\Workday;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkdayController extends Controller
{
    public function show(Workday $workday): View
    {
        return view('pages.workday', [
            'workday' => $workday,
        ]);
    }

    public function search(Request $request): View|RedirectResponse
    {
        if (! ($workday = Workday::whereDate('created_at', '=', $request->date)->first())) {
            return redirect()->route('alert', [
                'alert' => 'Workday',
                'message' => 'Workday',
                'action' => 'Not Found',
            ]);
        }

        return view('pages.workday', [
            'workday' => $workday,
            'tasks' => $workday->tasks,
        ]);
    }

    public function delete(DeleteWorkdayRequest $request, Workday $workday): View|RedirectResponse
    {
        $workday->delete();

        return ($latestWorkday = $workday->user->workdays()->latest()->first())
            ? view('pages.workday', [
                'workday' => $latestWorkday,
                'tasks' => $latestWorkday->tasks,
                'alert' => 'Workday',
                'action' => 'Deleted',
            ])
            : redirect()->route('alert', [
                'alert' => 'Workday',
                'message' => 'Workday',
                'action' => 'Deleted',
            ]);
    }
}
