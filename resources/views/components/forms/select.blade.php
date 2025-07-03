@props(['name' => '', 'label' => '', 'options' => [], 'selected' => ''])
<div>
    <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes }}
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
        @foreach ($options as $value => $label)
            <option @selected($selected === $value) value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
</div>
