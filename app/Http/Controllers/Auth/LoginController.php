<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'email'    => 'required|email',
                'password' => 'required|string|min:8',
            ],
            [
                'email.required'    => 'O campo de e-mail é obrigatório.',
                'email.email'       => 'O e-mail deve ser um endereço de e-mail válido.',
                'password.required' => 'O campo de senha é obrigatório.',
                'password.min'      => 'A senha deve ter pelo menos 8 caracteres.',
            ]
        );

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect('/');
    }
}
