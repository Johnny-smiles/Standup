<?php

namespace App\View\Components\Visuals;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RecentWorkdays extends Component
{
    public function __construct(public Collection $workdays)
    {
    }

    public function render(): View
    {
        return view('components.visuals.recent-workdays');
    }
}
