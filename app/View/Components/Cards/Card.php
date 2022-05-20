<?php

namespace App\View\Components\Cards;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(public ?string $color = 'gray-100', public ?string $spacing = '')
    {
    }

    public function render(): View
    {
        return view('components.cards.card');
    }
}
