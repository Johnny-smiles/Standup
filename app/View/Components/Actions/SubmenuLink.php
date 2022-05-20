<?php

namespace App\View\Components\Actions;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmenuLink extends Component
{
    public function __construct(public string $route, public string $linkText)
    {
    }

    public function render(): View
    {
        return view('components.actions.submenu-link');
    }
}
