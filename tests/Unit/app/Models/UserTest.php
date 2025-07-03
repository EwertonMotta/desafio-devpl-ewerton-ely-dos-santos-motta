<?php

declare(strict_types = 1);

namespace Tests\Unit\app\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('user model can be instantiated', function (): void {
    $user = User::factory()->make();

    expect($user)->toBeInstanceOf(User::class);
});

test('user has correct fillable attributes', function (): void {
    $user = new User();

    expect($user->getFillable())->toBe([
        'name',
        'email',
        'password',
    ]);
});

test('user has correct hidden attributes', function (): void {
    $user = new User();

    expect($user->getHidden())->toBe([
        'password',
    ]);
});

test('user has correct casts', function (): void {
    $user = new User();

    $reflection = new \ReflectionClass($user);
    $property   = $reflection->getProperty('casts');
    $property->setAccessible(true);
    $casts = $property->getValue($user);

    expect($casts)->toBeArray();
    expect($casts['password'])->toBe('hashed');
});

test('user has many tasks', function (): void {
    $user = User::factory()->create();
    Task::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->tasks)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
    expect($user->tasks)->toHaveCount(3);
    expect($user->tasks->first())->toBeInstanceOf(Task::class);
});

test('user factory creates valid user', function (): void {
    $user = User::factory()->create();

    expect($user->name)->not->toBeNull();
    expect($user->email)->not->toBeNull();
    expect($user->password)->not->toBeNull();
});
