<?php

namespace App\View\Components\Visuals;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public function render(): View
    {
        return view('components.visuals.navbar');
    }
}
