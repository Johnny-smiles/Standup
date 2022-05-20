<?php

namespace App\View\Components\Actions;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchTasks extends Component
{
    public function render(): View
    {
        return view('components.actions.search-tasks');
    }
}
