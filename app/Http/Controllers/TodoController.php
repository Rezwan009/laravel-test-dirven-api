<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todos = TodoList::all();
        return response($todos);
    }

    public function show(TodoList $todoList)
    {
        return response($todoList);
    }
    public function store(TodoListRequest $request)
    {
        return TodoList::create($request->all());
    }

    public function update(TodoListRequest $request, TodoList $todoList)
    {
        $todoList->update($request->all());
        return response($todoList, Response::HTTP_OK);
    }
    public function destroy(TodoList $todoList)
    {
        $todoList->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
