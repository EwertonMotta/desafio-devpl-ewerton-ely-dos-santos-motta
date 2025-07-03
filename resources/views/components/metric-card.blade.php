@props(['label' => '', 'principalValue' => 0, 'secondaryValue' => 0])
<div
    class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ $label }}
    </p>

    <div class="mt-3 flex items-end justify-between">
        <div>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                {{ $principalValue }}
            </h4>
        </div>

        <div class="flex items-center gap-1">
            <span
                class="{{ $secondaryValue < 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium dark:bg-green-500/15 dark:text-green-500">
                {{ $secondaryValue }}
            </span>

            <span class="text-xs text-gray-500 dark:text-gray-400">
                mês passado
            </span>
        </div>
    </div>
</div>
