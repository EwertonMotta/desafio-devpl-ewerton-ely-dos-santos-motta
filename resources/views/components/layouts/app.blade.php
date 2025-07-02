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
        <header class="border-b border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center space-x-6">
                    <x-logo class="h-8 w-auto" />
                    <div class="flex flex-1 items-center justify-between">
                        <div class="hidden items-center space-x-4 md:flex">
                            <x-nav-link href="{{ route('dashboard') }}" active="{{ request()->routeIs('dashboard') }}">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('to-do') }}" active="{{ request()->routeIs('to-do') }}">
                                Tarefas
                            </x-nav-link>
                        </div>
                        <div>
                            <div x-data="{ open: false }" class="relative">
                                <x-outline.primary-button type="button" label="{{ auth()->user()->name }}"
                                    x-on:click="open = !open" />
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 rounded-md bg-white shadow-lg">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">Sair</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex flex-grow justify-center p-5">
            <div class="container">
                {{ $slot }}
            </div>
        </main>

        <x-layouts.partials.footer />
    </div>

</body>

</html>
