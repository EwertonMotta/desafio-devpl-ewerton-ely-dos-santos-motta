@props(['task', 'loop' => null])
<li class="{{ $loop->last ? '' : 'pb-4  border-b' }} my-4 border-gray-200">
    <div class="flex items-center justify-between rounded-lg p-2 hover:bg-gray-50 dark:hover:bg-gray-700">
        <form id="toggle-task-{{ $task->id }}" action="{{ route('to-do.toggle', $task) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="query" value="{{ request()->getQueryString() }}">
            <x-to-do.icons.toggle :task="$task" />
        </form>
        <a href="{{ route('to-do.show', $task) }}"
            class="flex flex-1 items-center justify-between border-l-2 border-gray-200 px-4">
            <p class="mb-2 font-semibold">{{ $task->title }}</p>
            <div>
                <div class="flex items-center justify-end text-xs text-gray-600 dark:text-gray-400">
                    Criado em: <span class="ms-1.5 font-medium">{{ $task->created_at->format('d/m/Y') }}</span>
                </div>
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
        </a>

        <div class="ms-2 flex items-center justify-center space-x-2">
            <a href="{{ route('to-do.edit', $task) }}" title="Editar Tarefa"
                class="h-6 w-6 text-green-700 hover:text-green-900">
                <x-icons.edit />
                <span class="sr-only">Editar Tarefa</span>
            </a>
            <button class="h-6 w-6 cursor-pointer text-red-500 hover:text-red-700" title="Excluir Tarefa"
                x-on:click="$dispatch('open-delete-modal', { item: { taskId: {{ $task->id }}, taskTitle: '{{ $task->title }}' } })">
                <x-icons.trash />
                <span class="sr-only">Excluir Tarefa</span>
            </button>
        </div>
    </div>
</li>
