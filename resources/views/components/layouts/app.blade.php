<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen flex-col">
        <header class="border-b border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center space-x-6">
                    <x-logo class="h-12 w-auto" />
                    <div class="flex flex-1 items-center justify-between">
                        <div class="hidden items-center space-x-4 md:flex">
                            <x-nav-link href="{{ route('dashboard') }}" active="{{ request()->routeIs('dashboard') }}">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('to-do.index') }}" active="{{ request()->routeIs('to-do.*') }}">
                                Tarefas
                            </x-nav-link>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="font-medium text-gray-900 dark:text-gray-300">{{ auth()->user()->name }}</span>
                            <div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" title="Sair"
                                        class="inline-flex cursor-pointer items-center rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                        </svg>
                                    </button>
                                </form>
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

        @if ($errors->any())
            <ul class="fixed right-5 top-20">
                @foreach ($errors->all() as $error)
                    <li x-data="{ show: {{ $errors->any() ? 'true' : 'false' }} }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                        class="mb-4 flex items-center rounded-lg bg-red-50 p-4 text-red-800 dark:bg-gray-800 dark:text-red-400">
                        <svg class="h-4 w-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 text-sm font-medium">
                            {{ $error }}
                        </div>
                        <button type="button" x-on:click="show = false"
                            class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg bg-red-50 p-1.5 text-red-500 hover:bg-red-200 focus:ring-2 focus:ring-red-400 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                            data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif

        <x-layouts.partials.footer />
    </div>
    @vite(['resources/js/app.js'])
</body>

</html>
