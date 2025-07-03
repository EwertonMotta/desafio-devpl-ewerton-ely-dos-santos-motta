<x-layouts.app>
    <div x-data="deleteConfirmationModal" class="container flex flex-col items-center justify-center">
        <header class="max-w-4/5 mb-4 flex w-full items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ $task->title }}</h1>
                <div class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                    Criado em: <span class="ms-1.5 font-medium">{{ $task->created_at->format('d/m/Y \à\s H:i') }}</span>
                </div>
            </div>
            <x-solid.primary-button href="{{ route('to-do.index') }}">
                <x-icons.to-go-back />
                Voltar para a lista de tarefas
            </x-solid.primary-button>
        </header>
        <div x-data="deleteConfirmationModal"
            class="max-w-4/5 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="mb-2 text-lg font-bold">Detalhes da Tarefa</h2>
                <div>
                    @if ($task->deadline)
                        <div class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                            Prazo de Conclusão: <span
                                class="ms-1.5 font-medium">{{ $task->deadline->format('d/m/Y') }}</span>
                        </div>
                    @endif

                    @if ($task->completed_at)
                        <div class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                            Concluído em: <span
                                class="ms-1.5 font-medium">{{ $task->completed_at->format('d/m/Y \à\s H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="border-b-2 border-gray-200 dark:border-gray-700">
                <p class="mb-2 text-gray-900 dark:text-white">
                    {{ $task->description }}
                </p>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <x-solid.primary-button href="{{ route('to-do.edit', $task) }}" class="mt-4">
                    Editar Tarefa
                </x-solid.primary-button>
                <x-solid.danger-button type="button" class="mt-4" x-data
                    x-on:click="$dispatch('open-delete-modal', { item: { taskId: {{ $task->id }}, taskTitle: '{{ $task->title }}' } })">
                    Deletar Tarefa
                </x-solid.danger-button>
            </div>
        </div>
        @include('to-do.modals.delete')
    </div>
</x-layouts.app>
