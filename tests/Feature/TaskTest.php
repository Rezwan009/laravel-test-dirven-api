<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    private $task;
    private $todoList;
    public function setUp(): void
    {
        parent::setUp();

        $this->task = parent::createTask(['title' => 'Task Title']);
        $this->todoList = parent::createTodoList(['name' => 'Todo List']);
    }
    public function test_fetch_all_task_of_a_todo_list()
    {
        $response = $this->getJson(route('todo-list.task.index', $this->todoList->id))->assertOk()->json();
        $this->assertEquals(1, count($response));
        $this->assertEquals($this->task->title, $response[0]['title']);
    }

    public function test_store_a_task_for_a_todo_list()
    {
        $response = $this->postJson(route('todo-list.task.store', $this->todoList->id), [
            'title' => $this->task->title,
        ])
            ->assertCreated()
            ->json();

        $this->assertEquals($this->task->title, $response['title']);
        $this->assertDatabaseHas('tasks', ['title' => $this->task->title]);
    }


    public function test_update_a_task_for_a_todo_list()
    {
        $newTitle = 'Updated Task Title';
        $response = $this->putJson(route('task.update', $this->task->id), [
            'title' => $newTitle,
        ])
            ->assertOk()
            ->json();

        $this->assertEquals($newTitle, $response['title']);
        $this->assertDatabaseHas('tasks', ['title' => $newTitle]);
    }

    public function test_delete_a_task_for_a_todo_list()
    {
        $this->deleteJson(route('task.destroy', $this->task->id))->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
