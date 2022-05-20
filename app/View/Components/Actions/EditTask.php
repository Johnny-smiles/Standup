<?php

namespace App\View\Components\Actions;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditTask extends Component
{
    public function __construct(public Task $task)
    {
    }

    public function render(): View
    {
        return view('components.actions.edit-task');
    }
}
