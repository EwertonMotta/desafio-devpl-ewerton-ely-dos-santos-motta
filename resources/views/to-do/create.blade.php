<x-layouts.app>
    <div class="container flex flex-col items-center justify-center">
        <header class="max-w-4/5 mb-4 flex w-full items-center justify-between">
            <h1 class="mb-4 text-2xl font-bold">Criar Tarefa</h1>
            <x-solid.primary-button href="{{ route('to-do.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Voltar para a lista de tarefas
            </x-solid.primary-button>
        </header>
        <div
            class="max-w-4/5 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <form action="{{ route('to-do.store') }}" method="POST" class="space-y-4">
                @csrf
                @method('POST')
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="first_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Titulo
                        </label>
                        <input type="text" id="first_name" name="title"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Enviar Relatório Mensal" />
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                <span class="font-medium">Ops!</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="deadline" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Prazo de Conclusão
                            </label>
                            <input type="date" id="deadline" name="deadline"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" />
                            @error('deadline')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    <span class="font-medium">Ops!</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="flex flex-col items-center justify-center pt-3.5">
                            <div class="flex items-center pt-3.5 lg:justify-center">
                                <label class="me-5 inline-flex cursor-pointer items-center">
                                    <span
                                        class="me-3 text-sm font-medium text-gray-900 dark:text-gray-300">Concluído</span>
                                    <input type="checkbox" value="1" class="peer sr-only" name="completed"
                                        id="completed" />
                                    <div
                                        class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-green-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-green-600 dark:peer-focus:ring-green-800">
                                    </div>
                                </label>
                            </div>
                            @error('completed')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    <span class="font-medium">Ops!</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Descrição
                    </label>
                    <textarea id="message" rows="4" name="description"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Preparar e enviar o relatório mensal de vendas para o gerente de vendas até sexta-feira, 5 de julho. Incluir análise de desempenho, gráficos e principais métricas."></textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            <span class="font-medium">Ops!</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <x-solid.primary-button type="submit"
                        class="mb-2 me-2 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Salvar
                    </x-solid.primary-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
