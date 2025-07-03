<?php

declare(strict_types = 1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ToDoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('to-do', ToDoController::class)->parameters(['to-do' => 'task']);
    Route::put('to-do/{task}/toggle', [ToDoController::class, 'toggle'])->name('to-do.toggle');
});
