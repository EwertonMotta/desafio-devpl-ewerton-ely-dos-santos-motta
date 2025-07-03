<div x-cloak x-show="isOpen"
    class="fixed inset-0 bg-black opacity-75 transition-opacity"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-75"
    x-transition:leave="ease-in duration-300"
    x-transition:leave-start="opacity-75"
    x-transition:leave-end="opacity-0"
    x-on:click="isOpen = false">
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center bg-black p-4 text-center sm:items-center sm:p-0">
            <div x-show="isOpen"
                class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl opacity-100 transition-all sm:w-full sm:max-w-lg sm:p-6"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
