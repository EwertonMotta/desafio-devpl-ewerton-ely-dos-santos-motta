@props(['startName' => '', 'endName' => '', 'label' => '', 'startValue' => '', 'endValue' => ''])
<div>
    <label for="{{ $startName }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}</label>
    <div
        class="flex w-full items-center rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
        <input type="date" id="{{ $startName }}" name="{{ $startName }}" value="{{ $startValue }}"
            class="w-full text-sm text-gray-900 outline-none dark:text-white" />
        <span class="mx-2 text-gray-500">até</span>
        <input type="date" id="{{ $endName }}" name="{{ $endName }}" value="{{ $endValue }}"
            class="w-full text-sm text-gray-900 outline-none dark:text-white" />
    </div>
</div>
