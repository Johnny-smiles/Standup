<?php

namespace App\View\Components\Actions;

use App\Models\Task;
use App\Models\Workday;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{
    public function __construct(public string $class, public Task|Workday $model)
    {
    }

    public function render(): View
    {
        return view('components.actions.delete-modal');
    }
}
