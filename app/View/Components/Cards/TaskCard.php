<?php

namespace App\View\Components\Cards;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaskCard extends Component
{
    public Task $task;
    public ?string $status;
    public ?string $time;

    public function __construct(Task $task, string $statusShow)
    {
        $this->task = $task;

        if ($statusShow === 'show') {
            $this->status = $task->getStatusTextAttribute($this->task->status);
            $this->time = $task->getStatusTextAttribute($this->task->time);
        } else {
            $this->status = null;
            $this->time = null;
        }
    }

    public function render(): View
    {
        return view('components.cards.task-card');
    }
}
