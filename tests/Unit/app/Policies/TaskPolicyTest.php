<?php

declare(strict_types = 1);

namespace Tests\Unit\app\Policies;

use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('task policy allows owner to view task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $policy = new TaskPolicy();

    expect($policy->view($user, $task))->toBeTrue();
});

test('task policy denies non-owner to view task', function (): void {
    $owner    = User::factory()->create();
    $nonOwner = User::factory()->create();
    $task     = Task::factory()->create(['user_id' => $owner->id]);

    $policy = new TaskPolicy();

    expect($policy->view($nonOwner, $task))->toBeFalse();
});

test('task policy allows owner to update task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $policy = new TaskPolicy();

    expect($policy->update($user, $task))->toBeTrue();
});

test('task policy denies non-owner to update task', function (): void {
    $owner    = User::factory()->create();
    $nonOwner = User::factory()->create();
    $task     = Task::factory()->create(['user_id' => $owner->id]);

    $policy = new TaskPolicy();

    expect($policy->update($nonOwner, $task))->toBeFalse();
});

test('task policy allows owner to delete task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $policy = new TaskPolicy();

    expect($policy->delete($user, $task))->toBeTrue();
});

test('task policy denies non-owner to delete task', function (): void {
    $owner    = User::factory()->create();
    $nonOwner = User::factory()->create();
    $task     = Task::factory()->create(['user_id' => $owner->id]);

    $policy = new TaskPolicy();

    expect($policy->delete($nonOwner, $task))->toBeFalse();
});
