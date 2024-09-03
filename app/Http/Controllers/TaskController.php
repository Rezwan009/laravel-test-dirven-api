<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public  function index()
    {
        $tasks = Task::all();
        return response($tasks);
    }
    public  function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        return Task::create($request->all());
    }
    public  function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $task->update($request->all());
        return response($task, Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
