<?php

namespace App\View\Components\Visuals;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class VisualsLayout extends Component
{
    public Collection $currentWorkdays;
    public Collection $previousWorkdays;

    public function __construct()
    {
        $now = Carbon::now();

        $this->currentWorkdays = auth()->user()->workdays()
            ->where('created_at', '>=', $now->startOfWeek()->format('Y-m-d H:i'))
            ->where('created_at', '<=', $now->endOfWeek()->subDays(2)->format('Y-m-d H:i'))
            ->get();

        $this->previousWorkdays = auth()->user()->workdays()
            ->where('created_at', '>=', $now->startOfWeek()->subDays(7)->format('Y-m-d H:i'))
            ->where('created_at', '<=', $now->endOfWeek()->subDays(2)->format('Y-m-d H:i'))
            ->get();
    }

    public function render(): View
    {
        return view('components.visuals.visuals-layout');
    }
}
