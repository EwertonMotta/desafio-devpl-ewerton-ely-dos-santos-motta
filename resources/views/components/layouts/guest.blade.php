<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen flex-col">
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-end">
                    <div class="hidden items-center space-x-4 md:flex">
                        @if (Route::has('login'))
                            @auth
                                <x-outline.primary-button href="{{ url('/dashboard') }}" label="Dashboard" />
                            @else
                                <x-outline.primary-button href="{{ route('login') }}" label="Login" />
                                @if (Route::has('register'))
                                    <x-outline.primary-button href="{{ route('register') }}" label="Register" />
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="flex flex-grow items-center justify-center">
            {{ $slot }}
        </main>

        <x-layouts.partials.footer />
    </div>

</body>

</html>
