<?php

declare(strict_types = 1);

namespace Tests\Feature\app\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('register page can be rendered', function (): void {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
    $response->assertViewIs('auth.register');
});

test('new users can register', function (): void {
    $response = $this->post(route('register'), [
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name'  => 'Test User',
        'email' => 'test@example.com',
    ]);
});

test('registration validates required fields', function (): void {
    $response = $this->post(route('register'), [
        'name'     => '',
        'email'    => '',
        'password' => '',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
    $this->assertDatabaseMissing('users', ['email' => '']);
    $this->assertGuest();
});

test('registration validates email format', function (): void {
    $response = $this->post(route('register'), [
        'name'     => 'Test User',
        'email'    => 'not-an-email',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseMissing('users', ['name' => 'Test User']);
    $this->assertGuest();
});

test('registration validates password length', function (): void {
    $response = $this->post(route('register'), [
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => '1234567',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    $this->assertGuest();
});

test('registration validates unique email', function (): void {
    $existingUser = User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $response = $this->post(route('register'), [
        'name'     => 'Another User',
        'email'    => 'existing@example.com',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseCount('users', 1);
    $this->assertGuest();
});

test('password is hashed during registration', function (): void {
    $plainPassword = 'password123';

    $this->post(route('register'), [
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => $plainPassword,
    ]);

    $user = User::where('email', 'test@example.com')->first();
    $this->assertNotEquals($plainPassword, $user->password);
    $this->assertTrue(password_verify($plainPassword, (string) $user->password));
});
