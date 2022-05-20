<?php

namespace App\View\Components\Visuals;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(public string $alert, public string $action)
    {
    }

    public function render(): View
    {
        return view('components.visuals.alert');
    }
}
