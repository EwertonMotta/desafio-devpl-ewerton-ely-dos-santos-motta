<x-layouts.app>
    <div class="container flex flex-col items-center justify-center space-y-4">
        <header class="max-w-4/5 flex w-full items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Lista de Tarefas</h1>
                @if ($tasksCount)
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Você tem
                        <span
                            class="text-sm font-semibold text-gray-900 dark:text-gray-300">{{ $pendingTasksCount }}</span>
                        tarefa{{ $pendingTasksCount === 1 ? '' : 's' }}
                        pendente{{ $pendingTasksCount === 1 ? '' : 's' }} de
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-300"> {{ $tasksCount }}</span>.
                    </p>
                @endif
            </div>
            <div class="flex justify-between">
                <x-solid.primary-button href="{{ route('to-do.create') }}">
                    <x-icons.add />
                    Adicionar Tarefa
                </x-solid.primary-button>
            </div>
        </header>
        <div
            class="max-w-4/5 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form action="{{ route('to-do.index') }}" method="GET"
                class="flex flex-col items-center justify-between space-x-4 md:flex-row">
                <div class="flex-1">
                    <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                        <x-forms.input name="title" label="Buscar" placeholder="Buscar Tarefa"
                            value="{{ request('title') }}" />

                        <x-forms.date-range startName="start_created_at" endName="end_created_at"
                            startValue="{{ request('start_created_at') }}" endValue="{{ request('end_created_at') }}"
                            label="Data de Criação" />


                        <x-forms.date-range startName="start_deadline" endName="end_deadline"
                            startValue="{{ request('start_deadline') }}" endValue="{{ request('end_deadline') }}"
                            label="Prazo de Conclusão" />

                        <div class="flex items-end justify-end gap-2 space-x-2 lg:flex-row-reverse">
                            <x-solid.light-button href="{{ route('to-do.index') }}">
                                Limpar
                            </x-solid.light-button>

                            <x-solid.primary-button type="submit">
                                <x-icons.search />
                                <span class="sr-only">Buscar</span>
                            </x-solid.primary-button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 block w-full lg:mt-0 lg:w-fit">
                    <x-forms.select name="orderBy" label="Ordenar por" onChange="this.form.submit()" :options="[
                        'created_at-asc' => 'Data de Criação Mais Antiga',
                        'created_at-desc' => 'Data de Criação Mais Recente',
                        'deadline-asc' => 'Prazo de Conclusão Mais Antigo',
                        'deadline-desc' => 'Prazo de Conclusão Mais Recente',
                        'title-asc' => 'Título A-Z',
                        'title-desc' => 'Título Z-A',
                    ]"
                        :selected="request('orderBy')" />
                </div>
            </form>
        </div>

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
            @if ($tasks->hasPages())
                <div class="mt-4 flex items-center justify-center">
                    {{ $tasks->links() }}
                </div>
            @endif
            @include('to-do.modals.delete')
        </div>
    </div>
</x-layouts.app>
