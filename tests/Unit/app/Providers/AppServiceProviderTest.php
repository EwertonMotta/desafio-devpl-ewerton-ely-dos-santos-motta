<?php

declare(strict_types = 1);

namespace Tests\Unit\app\Providers;

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('app service provider can be instantiated', function (): void {
    $provider = new AppServiceProvider(app());

    expect($provider)->toBeInstanceOf(AppServiceProvider::class);
});

test('app service provider register method executes without errors', function (): void {
    $provider = new AppServiceProvider(app());

    // This test just ensures the method doesn't throw exceptions
    $provider->register();

    // If we get here without exceptions, the test passes
    expect(true)->toBeTrue();
});

test('app service provider boot method executes without errors', function (): void {
    $provider = new AppServiceProvider(app());

    // This test just ensures the method doesn't throw exceptions
    $provider->boot();

    // If we get here without exceptions, the test passes
    expect(true)->toBeTrue();
});
