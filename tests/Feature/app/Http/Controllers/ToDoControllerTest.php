<?php

declare(strict_types = 1);

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('index method displays tasks for authenticated user', function (): void {
    $user  = User::factory()->create();
    $tasks = Task::factory()->count(5)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('to-do.index'));

    $response->assertStatus(200);
    $response->assertViewIs('to-do.index');
    $response->assertViewHas('tasks');
    $response->assertViewHas('pendingTasksCount');
    $response->assertViewHas('tasksCount');
});

test('index method filters tasks by title', function (): void {
    $user  = User::factory()->create();
    $task1 = Task::factory()->create([
        'user_id' => $user->id,
        'title'   => 'Special Task Title',
    ]);
    $task2 = Task::factory()->create([
        'user_id' => $user->id,
        'title'   => 'Regular Task',
    ]);

    $response = $this->actingAs($user)->get(route('to-do.index', ['title' => 'Special']));

    $response->assertStatus(200);
    $response->assertViewHas('tasks', fn ($tasks): bool => $tasks->contains($task1) && $tasks->count() === 1);
});

test('index method filters tasks by date range', function (): void {
    $user  = User::factory()->create();
    $task1 = Task::factory()->create([
        'user_id'    => $user->id,
        'created_at' => now()->subDays(5),
    ]);
    $task2 = Task::factory()->create([
        'user_id'    => $user->id,
        'created_at' => now()->subDays(1),
    ]);

    $startDate = now()->subDays(3)->format('Y-m-d');
    $endDate   = now()->format('Y-m-d');

    $response = $this->actingAs($user)
        ->get(route('to-do.index', [
            'start_created_at' => $startDate,
            'end_created_at'   => $endDate,
        ]));

    $response->assertStatus(200);
    $response->assertViewHas('tasks', fn ($tasks): bool => $tasks->contains($task2) && $tasks->count() === 1);
});

test('index method filters tasks by deadline', function (): void {
    $user  = User::factory()->create();
    $task1 = Task::factory()->create([
        'user_id'  => $user->id,
        'deadline' => now()->addDays(5),
    ]);
    $task2 = Task::factory()->create([
        'user_id'  => $user->id,
        'deadline' => now()->addDays(15),
    ]);

    $startDate = now()->addDays(4)->format('Y-m-d');
    $endDate   = now()->addDays(10)->format('Y-m-d');

    $response = $this->actingAs($user)
        ->get(route('to-do.index', [
            'start_deadline' => $startDate,
            'end_deadline'   => $endDate,
        ]));

    $response->assertStatus(200);
    $response->assertViewHas('tasks', fn ($tasks): bool => $tasks->contains($task1) && $tasks->count() === 1);
});

test('toggle method marks task as completed', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'      => $user->id,
        'completed'    => false,
        'completed_at' => null,
    ]);

    $response = $this->actingAs($user)->put(route('to-do.toggle', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $task->refresh();
    expect($task->completed)->toBeTrue();
    expect($task->completed_at)->not->toBeNull();
});

test('toggle method redirects with error when task is already completed', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'      => $user->id,
        'completed'    => true,
        'completed_at' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('to-do.toggle', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
});

test('toggle method redirects with error for unauthorized user', function (): void {
    $owner = User::factory()->create();
    $task  = Task::factory()->create([
        'user_id'   => $owner->id,
        'completed' => false,
    ]);

    $anotherUser = User::factory()->create();

    $response = $this->actingAs($anotherUser)->put(route('to-do.toggle', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
});

test('create method displays create form', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('to-do.create'));

    $response->assertStatus(200);
    $response->assertViewIs('to-do.create');
});

test('store method creates new task', function (): void {
    $user = User::factory()->create();

    $taskData = [
        'title'       => 'New Task',
        'description' => 'Task Description',
        'deadline'    => now()->addDays(5)->format('Y-m-d'),
    ];

    $response = $this->actingAs($user)->post(route('to-do.store'), $taskData);

    $response->assertRedirect(route('to-do.index'));
    $this->assertDatabaseHas('tasks', [
        'title'       => 'New Task',
        'description' => 'Task Description',
        'user_id'     => $user->id,
    ]);
});

test('store method creates completed task when completed is true', function (): void {
    $user = User::factory()->create();

    $taskData = [
        'title'       => 'New Completed Task',
        'description' => 'Task Description',
        'deadline'    => now()->addDays(5)->format('Y-m-d'),
        'completed'   => true,
    ];

    $response = $this->actingAs($user)->post(route('to-do.store'), $taskData);

    $response->assertRedirect(route('to-do.index'));
    $this->assertDatabaseHas('tasks', [
        'title'     => 'New Completed Task',
        'completed' => true,
        'user_id'   => $user->id,
    ]);
});

test('show method displays task details', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('to-do.show', $task->id));

    $response->assertStatus(200);
    $response->assertViewIs('to-do.show');
    $response->assertViewHas('task', $task);
});

test('show method redirects with error for unauthorized user', function (): void {
    $owner = User::factory()->create();
    $task  = Task::factory()->create(['user_id' => $owner->id]);

    $anotherUser = User::factory()->create();

    $response = $this->actingAs($anotherUser)->get(route('to-do.show', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
});

test('edit method displays edit form', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'   => $user->id,
        'completed' => false,
    ]);

    $response = $this->actingAs($user)->get(route('to-do.edit', $task->id));

    $response->assertStatus(200);
    $response->assertViewIs('to-do.edit');
    $response->assertViewHas('task', $task);
});

test('edit method redirects with error for unauthorized user', function (): void {
    $owner = User::factory()->create();
    $task  = Task::factory()->create(['user_id' => $owner->id]);

    $anotherUser = User::factory()->create();

    $response = $this->actingAs($anotherUser)->get(route('to-do.edit', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
});

test('update method updates task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'     => $user->id,
        'title'       => 'Old Title',
        'description' => 'Old Description',
        'completed'   => false,
    ]);

    $updatedData = [
        'title'       => 'Updated Title',
        'description' => 'Updated Description',
        'deadline'    => now()->addDays(10)->format('Y-m-d'),
    ];

    $response = $this->actingAs($user)->put(route('to-do.update', $task->id), $updatedData);

    $response->assertRedirect(route('to-do.index'));
    $task->refresh();
    expect($task->title)->toBe('Updated Title');
    expect($task->description)->toBe('Updated Description');
});

test('update method redirects with error for unauthorized user', function (): void {
    $owner = User::factory()->create();
    $task  = Task::factory()->create(['user_id' => $owner->id]);

    $anotherUser = User::factory()->create();

    $response = $this->actingAs($anotherUser)->put(route('to-do.update', $task->id), [
        'title'    => 'Unauthorized Update',
        'deadline' => now()->addDays(5)->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
});

test('update method redirects with error when task is completed', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'      => $user->id,
        'title'        => 'Completed Task',
        'completed'    => true,
        'completed_at' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('to-do.update', $task->id), [
        'title'    => 'Try to update completed task',
        'deadline' => now()->addDays(5)->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
});

test('destroy method deletes task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'   => $user->id,
        'completed' => false,
    ]);

    $response = $this->actingAs($user)->delete(route('to-do.destroy', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('destroy method redirects with error for unauthorized user', function (): void {
    $owner = User::factory()->create();
    $task  = Task::factory()->create(['user_id' => $owner->id]);

    $anotherUser = User::factory()->create();

    $response = $this->actingAs($anotherUser)->delete(route('to-do.destroy', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
    $this->assertDatabaseHas('tasks', ['id' => $task->id]);
});

test('destroy method redirects with error when task is completed', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'      => $user->id,
        'completed'    => true,
        'completed_at' => now(),
    ]);

    $response = $this->actingAs($user)->delete(route('to-do.destroy', $task->id));

    $response->assertRedirect(route('to-do.index'));
    $response->assertSessionHasErrors('error');
    $this->assertDatabaseHas('tasks', ['id' => $task->id]);
});

test('toggle method preserves query parameters in redirect', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'user_id'      => $user->id,
        'completed'    => false,
        'completed_at' => null,
    ]);

    $queryString = 'title=Test&start_created_at=2025-07-01&end_created_at=2025-07-03';

    $response = $this->actingAs($user)
        ->put(route('to-do.toggle', [
            'task'  => $task->id,
            'query' => $queryString,
        ]));

    $response->assertRedirect(route('to-do.index', [
        'title'            => 'Test',
        'start_created_at' => '2025-07-01',
        'end_created_at'   => '2025-07-03',
    ]));

    $task->refresh();
    expect($task->completed)->toBeTrue();
    expect($task->completed_at)->not->toBeNull();
});
