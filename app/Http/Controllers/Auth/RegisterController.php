<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ],
            [
                'name.required'     => 'O campo nome é obrigatório.',
                'email.required'    => 'O campo e-mail é obrigatório.',
                'email.email'       => 'O e-mail deve ser um endereço de e-mail válido.',
                'email.unique'      => 'Este e-mail já está em uso.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.min'      => 'A senha deve ter pelo menos 8 caracteres.',
            ]
        );

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
