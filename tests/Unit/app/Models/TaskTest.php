<?php

declare(strict_types = 1);

namespace Tests\Unit\app\Models;

use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('task model can be instantiated', function (): void {
    $task = Task::factory()->make();

    expect($task)->toBeInstanceOf(Task::class);
});

test('task has correct fillable attributes', function (): void {
    $task = new Task();

    expect($task->getFillable())->toBe([
        'user_id',
        'title',
        'description',
        'deadline',
        'completed',
        'completed_at',
    ]);
});

test('task has correct casts', function (): void {
    $task = new Task();

    expect($task->getCasts())->toMatchArray([
        'deadline'     => 'datetime',
        'completed'    => 'boolean',
        'completed_at' => 'datetime',
    ]);
});

test('task belongs to user', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    expect($task->user)->toBeInstanceOf(User::class);
    expect($task->user->id)->toBe($user->id);
});

test('task factory creates valid task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    expect($task->title)->not->toBeNull();
    expect($task->user_id)->toBe($user->id);
});

test('task pending scope filters incomplete tasks', function (): void {
    $user = User::factory()->create();
    Task::factory()->count(3)->create([
        'user_id'   => $user->id,
        'completed' => false,
    ]);

    Task::factory()->count(2)->create([
        'user_id'   => $user->id,
        'completed' => true,
    ]);

    $pendingTasks = Task::query()->pending()->get();

    expect($pendingTasks)->toHaveCount(3);
    $pendingTasks->each(function ($task): void {
        expect($task->completed)->toBeFalse();
    });
});

test('task completed scope filters completed tasks', function (): void {
    $user = User::factory()->create();
    Task::factory()->count(3)->create([
        'user_id'   => $user->id,
        'completed' => false,
    ]);

    Task::factory()->count(2)->create([
        'user_id'   => $user->id,
        'completed' => true,
    ]);

    $completedTasks = Task::query()->completed()->get();

    expect($completedTasks)->toHaveCount(2);
    $completedTasks->each(function ($task): void {
        expect($task->completed)->toBeTrue();
    });
});

test('task uses TaskPolicy', function (): void {
    $reflectionClass = new \ReflectionClass(Task::class);
    $attributes      = $reflectionClass->getAttributes();

    $found = false;

    foreach ($attributes as $attribute) {
        if ($attribute->getName() === \Illuminate\Database\Eloquent\Attributes\UsePolicy::class) {
            $arguments = $attribute->getArguments();

            if ($arguments[0] === TaskPolicy::class) {
                $found = true;

                break;
            }
        }
    }

    expect($found)->toBeTrue();
});
