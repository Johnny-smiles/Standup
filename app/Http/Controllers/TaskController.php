<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function show(Request $request): View
    {
        $tasks = $request->user()
            ->tasks()
            ->where('text', 'ILIKE', '%'.$request->text.'%')
            ->get();

        return view('pages.home', [
            'tasks' => $tasks,
            'completedTasks' => $tasks->where('status', '=', 'completed'),
            'inProgressTasks' => $tasks->where('status', '=', 'in_progress'),
            'blockedTasks' => $tasks->where('status', '=', 'blocked'),
            'deletedTasks' => $tasks->where('status', '=', 'deleted'),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): View
    {
        $task->update([
            'text' => $request->input('text'),
            'status' => $request->input('status', $task->status),
        ]);

        return view('pages.workday', [
            'workday' => $workday = $task->workday,
            'tasks' => $workday->tasks,
            'alert' => 'Task',
            'action' => 'Updated',
        ]);
    }

    public function delete(DeleteTaskRequest $request, Task $task): View
    {
        $task->delete();

        return view('pages.workday', [
            'workday' => $task->workday,
            'tasks' => $task->workday->tasks,
            'alert' => 'Task',
            'action' => 'Deleted',
        ]);
    }
}
