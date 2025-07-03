<?php

declare(strict_types = 1);

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('dashboard shows pending tasks for authenticated user', function (): void {
    $user  = User::factory()->create();
    $tasks = Task::factory()->count(5)->create([
        'user_id'   => $user->id,
        'completed' => false,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
    $response->assertViewHas('tasks');
});

test('dashboard limits displayed tasks to 5', function (): void {
    $user  = User::factory()->create();
    $tasks = Task::factory()->count(8)->create([
        'user_id'   => $user->id,
        'completed' => false,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('tasks', fn($viewTasks): bool => $viewTasks->count() === 5);
});

test('dashboard shows tasks created in current month', function (): void {
    $user = User::factory()->create();
    $tasksThisMonth = Task::factory()->count(3)->create([
        'user_id'    => $user->id,
        'created_at' => now(),
    ]);

    $tasksLastMonth = Task::factory()->count(2)->create([
        'user_id'    => $user->id,
        'created_at' => now()->subMonth(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('createdCurrentMonth', 3);
    $response->assertViewHas('createdLastMonth', 2);
});

test('dashboard shows tasks completed in current month', function (): void {
    $user = User::factory()->create();
    $tasksCompletedThisMonth = Task::factory()->count(3)->create([
        'user_id'      => $user->id,
        'completed'    => true,
        'completed_at' => now(),
    ]);

    $tasksCompletedLastMonth = Task::factory()->count(2)->create([
        'user_id'      => $user->id,
        'completed'    => true,
        'completed_at' => now()->subMonth(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('completedCurrentMonth', 3);
    $response->assertViewHas('completedLastMonth', 2);
});

test('dashboard shows tasks created and completed in the same month', function (): void {
    $user = User::factory()->create();

    $tasksCurrentMonth = Task::factory()->count(3)->create([
        'user_id'      => $user->id,
        'completed'    => true,
        'created_at'   => now(),
        'completed_at' => now(),
    ]);

    $tasksLastMonth = Task::factory()->count(2)->create([
        'user_id'      => $user->id,
        'completed'    => true,
        'created_at'   => now()->subMonth(),
        'completed_at' => now()->subMonth(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('createdCompletedCurrentMonth', 3);
    $response->assertViewHas('createdCompletedLastMonth', 2);
});

test('dashboard shows pending tasks created in each month', function (): void {
    $user = User::factory()->create();

    $pendingTasksCurrentMonth = Task::factory()->count(4)->create([
        'user_id'    => $user->id,
        'completed'  => false,
        'created_at' => now(),
    ]);

    $pendingTasksLastMonth = Task::factory()->count(3)->create([
        'user_id'    => $user->id,
        'completed'  => false,
        'created_at' => now()->subMonth(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('createdPendingCurrentMonth', 4);
    $response->assertViewHas('createdPendingLastMonth', 3);
});

test('dashboard only shows tasks for authenticated user', function (): void {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $tasksUser1 = Task::factory()->count(5)->create(['user_id' => $user1->id]);
    $tasksUser2 = Task::factory()->count(3)->create(['user_id' => $user2->id]);

    $response = $this->actingAs($user1)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('tasks', fn($tasks) => $tasks->every(fn ($task): bool => $task->user_id === $user1->id));
});

test('dashboard handles date ranges correctly', function (): void {
    Carbon::setTestNow('2025-07-03');

    $user = User::factory()->create();

    Task::factory()->create([
        'user_id'      => $user->id,
        'created_at'   => Carbon::parse('2025-06-15'),
        'completed_at' => null,
        'completed'    => false,
    ]);

    Task::factory()->create([
        'user_id'      => $user->id,
        'created_at'   => Carbon::parse('2025-07-01'),
        'completed_at' => null,
        'completed'    => false,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('createdCurrentMonth', 1);
    $response->assertViewHas('createdLastMonth', 1);

    Carbon::setTestNow();
});
