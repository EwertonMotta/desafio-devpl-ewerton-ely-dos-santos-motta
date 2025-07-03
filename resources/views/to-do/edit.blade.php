<x-layouts.app>
    <div class="container flex flex-col items-center justify-center">
        <header class="max-w-4/5 mb-4 flex w-full items-center justify-between">
            <h1 class="mb-4 text-2xl font-bold">Editar Tarefa</h1>
            <x-solid.primary-button href="{{ route('to-do.index') }}">
                <x-icons.to-go-back />
                Voltar para a lista de tarefas
            </x-solid.primary-button>
        </header>
        <div
            class="max-w-4/5 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <form action="{{ route('to-do.update', $task) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-forms.input name="title" type="text" label="Titulo" value="{{ old('title', $task->title) }}"
                        placeholder="Enviar Relatório Mensal" />
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <x-forms.input name="deadline" type="date" label="Prazo de Conclusão"
                            value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}" />
                        <x-forms.toggle name="completed" label="Concluído" :checked="old('completed', $task->completed)" />
                    </div>
                </div>

                <x-forms.textarea name="description" label="Descrição" placeholder="Descreva a tarefa que deseja editar"
                    rows="4" value="{{ old('description', $task->description) }}" />

                <div class="flex items-center justify-end">
                    <x-solid.primary-button type="submit">
                        Salvar
                    </x-solid.primary-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
