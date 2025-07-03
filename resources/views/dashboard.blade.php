<x-layouts.app>
    <div class="container flex flex-col items-center justify-center space-y-4">
        <header class="max-w-4/5 flex w-full items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
            </div>
            <div class="flex justify-between">
                <x-solid.primary-button href="{{ route('to-do.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Adicionar Tarefa
                </x-solid.primary-button>
            </div>
        </header>
        <div
            class="max-w-4/5 w-full rounded-lg border border-gray-200 bg-white p-2 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="grid grid-cols-1 gap-4 p-2 md:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Criadas no mês atual
                    </p>

                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                {{ $createdCurrentMonth }}
                            </h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <span
                                class="{{ $createdLastMonth < 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium dark:bg-green-500/15 dark:text-green-500">
                                {{ $createdLastMonth }}
                            </span>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                mês passado
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Concluídas no mês atual
                    </p>

                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                {{ $completedCurrentMonth }}
                            </h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <span
                                class="{{ $completedLastMonth < 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium dark:bg-green-500/15 dark:text-green-500">
                                {{ $completedLastMonth }}
                            </span>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                mês passado
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Criadas e concluídas no mês atual
                    </p>

                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                {{ $createdCompletedCurrentMonth }}
                            </h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <span
                                class="{{ $createdCompletedLastMonth < 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium dark:bg-green-500/15 dark:text-green-500">
                                {{ $createdCompletedLastMonth }}
                            </span>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                mês passado
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Criadas no mês atual e ainda pendentes
                    </p>

                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                {{ $createdPendingCurrentMonth }}
                            </h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <span
                                class="{{ $createdPendingLastMonth < 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium dark:bg-green-500/15 dark:text-green-500">
                                {{ $createdPendingLastMonth }}
                            </span>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                mês passado
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <header class="max-w-4/5 flex w-full items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">Tarefas Pendentes</h2>
                <p class="text-xs text-gray-400 dark:text-gray-200">
                    Aqui estão suas tarefas pendentes mais antigas.
                </p>
            </div>
        </header>

        <div x-data="deleteConfirmationModal"
            class="max-w-4/5 w-full rounded-lg border border-gray-200 bg-white p-2 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <ul class="px-4">
                @forelse ($tasks as $task)
                    <li class="{{ $loop->last ? '' : 'pb-4  border-b' }} my-4 border-gray-200">
                        <div
                            class="flex items-center justify-between rounded-lg p-2 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <form id="toggle-task-{{ $task->id }}" action="{{ route('to-do.toggle', $task) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="query" value="{{ request()->getQueryString() }}">
                                <label class="me-5 flex cursor-pointer flex-col items-center justify-center">
                                    <span
                                        class="{{ $task->completed ? 'font-semibold text-green-600' : '' }} mb-1 text-sm text-gray-900 dark:text-gray-300">
                                        @if ($task->completed)
                                            Concluído
                                        @else
                                            Pendente
                                        @endif
                                    </span>
                                    <input type="checkbox" value="" class="peer sr-only" name="completed"
                                        onChange="document.getElementById('toggle-task-{{ $task->id }}').submit()"
                                        id="completed" @checked($task->completed) />
                                    <div
                                        class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-green-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-green-600 dark:peer-focus:ring-green-800">
                                    </div>
                                </label>
                            </form>
                            <a href="{{ route('to-do.show', $task) }}"
                                class="flex flex-1 items-center justify-between border-l-2 border-gray-200 px-4">
                                <p class="mb-2 font-semibold">{{ $task->title }}</p>
                                <div>
                                    <div class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                                        Criado em: <span
                                            class="ms-1.5 font-medium">{{ $task->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    @if ($task->deadline)
                                        <div
                                            class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                                            Prazo de Conclusão: <span
                                                class="ms-1.5 font-medium">{{ $task->deadline->format('d/m/Y') }}</span>
                                        </div>
                                    @endif

                                    @if ($task->completed_at)
                                        <div
                                            class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                                            Concluído em: <span
                                                class="ms-1.5 font-medium">{{ $task->completed_at->format('d/m/Y \à\s H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <div class="ms-2 flex items-center justify-center space-x-2">
                                <a href="{{ route('to-do.edit', $task) }}"
                                    class="h-6 w-6 text-green-700 hover:text-green-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button class="h-6 w-6 cursor-pointer text-red-500 hover:text-red-700"
                                    x-on:click="$dispatch('open-delete-modal', { item: { taskId: {{ $task->id }}, taskTitle: '{{ $task->title }}' } })">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-gray-500">
                        Você ainda não tem tarefas. <a href="{{ route('to-do.create') }}"
                            class="text-blue-600 hover:underline">Crie uma nova tarefa</a>.
                    </li>
                @endforelse
            </ul>
            @include('to-do.modals.delete')
        </div>
    </div>
</x-layouts.app>
