<x-modal>
    <form method="POST" x-on:submit.prevent id="delete-form" x-ref="delete-form">
        @csrf
        @method('DELETE')
        <div>
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                    Confirmar exclusão
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        Tem certeza de que deseja excluir o seguinte item?
                    </p>
                    <template x-if="itemToDelete">
                        <p class="mt-2 overflow-x-auto rounded-md bg-gray-50 p-2 text-center font-semibold text-gray-800"
                            x-text="itemToDelete.taskTitle"></p>
                    </template>
                </div>
            </div>
        </div>
        <div class="mt-5 gap-3 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2">
            <x-solid.light-button type="button" x-on:click="isOpen = false">
                Cancelar
            </x-solid.light-button>
            <x-solid.danger-button type="submit" x-on:click="$dispatch('delete-item', itemToDelete); isOpen = false">
                Confirmar Exclusão
            </x-solid.danger-button>
        </div>
    </form>
</x-modal>
