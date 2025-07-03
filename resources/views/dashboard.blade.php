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
                <x-metric-card label="Criadas no mês atual"
                    principalValue="{{ $createdCurrentMonth }}"
                    secondaryValue="{{ $createdLastMonth }}" />

                <x-metric-card label="Concluídas no mês atual"
                    principalValue="{{ $completedCurrentMonth }}"
                    secondaryValue="{{ $completedLastMonth }}" />

                <x-metric-card label="Criadas e concluídas no mês atual"
                    principalValue="{{ $createdCompletedCurrentMonth }}"
                    secondaryValue="{{ $createdCompletedLastMonth }}" />

                <x-metric-card label="Criadas no mês atual e ainda pendentes"
                    principalValue="{{ $createdPendingCurrentMonth }}"
                    secondaryValue="{{ $createdPendingLastMonth }}" />
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
                    <x-to-do.task-item :task="$task" :loop="$loop" />
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
