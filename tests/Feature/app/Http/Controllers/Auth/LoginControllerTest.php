<?php

declare(strict_types = 1);

namespace Tests\Feature\app\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('login page can be rendered', function (): void {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
});

test('users can login with correct credentials', function (): void {
    $user = User::factory()->create([
        'email'    => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email'    => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('dashboard');
    $this->assertAuthenticated();
});

test('users cannot login with invalid password', function (): void {
    $user = User::factory()->create([
        'email'    => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email'    => 'test@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('users cannot login with email that does not exist', function (): void {
    $response = $this->post(route('login'), [
        'email'    => 'nonexistent@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('login validates email field', function (): void {
    $response = $this->post(route('login'), [
        'email'    => '',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('login validates password field', function (): void {
    $response = $this->post(route('login'), [
        'email'    => 'test@example.com',
        'password' => '',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});

test('users can logout', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);
    $this->assertAuthenticated();

    $response = $this->post(route('logout'));

    $response->assertRedirect('/');
    $this->assertGuest();
});
