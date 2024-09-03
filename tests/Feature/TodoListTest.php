<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Database\Factories\TodoListFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    private $todoList;
    public function setUp(): void
    {
        parent::setUp();
        $this->todoList = parent::createTodoList(['name' => 'My Todo List']);
    }
    public function test_fetch_all_todo_list()
    {
        $response = $this->getJson(route('todo-list.index'));
        $this->assertEquals(1, count($response->json()));
    }

    public function test_fetch_single_todo_list()
    {
        $response = $this->getJson(route('todo-list.show', $this->todoList->id))
            ->assertOk()
            ->json();
        $this->assertEquals($this->todoList->id, $response['id']);
    }

    public function test_store_new_todo_list()
    {
        $list = TodoList::factory()->make();

        $response = $this->postJson(route('todo-list.store'), [
            'name' => $list->name,
        ])
            ->assertCreated()
            ->json();
        $this->assertEquals($list->name, $response['name']);
        $this->assertDatabaseHas('todo_lists', [
            'name' => $list->name,
        ]);
    }

    public function test_while_storing_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-list.store'), [])
            ->assertStatus(422)
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name')
            ->json();
        $this->assertEquals('The name field is required.', $response['errors']['name'][0]);
    }

    public function test_update_existing_todo_list()
    {
        $response = $this->putJson(route('todo-list.update', $this->todoList->id), [
            'name' => 'New Todo List',
        ])
            ->assertOk()
            ->json();

        $this->assertEquals('New Todo List', $response['name']);
        $this->assertDatabaseHas('todo_lists', [
            'id' => $this->todoList->id,
            'name' => 'New Todo List',
        ]);
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-list.destroy', $this->todoList->id))
            ->assertNoContent();
        $this->assertDatabaseMissing('todo_lists',  ['id' => $this->todoList->id]);
    }
    public function test_while_updating_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->putJson(route('todo-list.update', $this->todoList->id), [])
            ->assertStatus(422)
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name')
            ->json();
        $this->assertEquals('The name field is required.', $response['errors']['name'][0]);
    }
}
