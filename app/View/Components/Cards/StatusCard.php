<?php

namespace App\View\Components\Cards;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class StatusCard extends Component
{
    public function __construct(public string $status, public ?Collection $tasks)
    {
    }

    public function render(): View
    {
        return view('components.cards.status-card');
    }
}
