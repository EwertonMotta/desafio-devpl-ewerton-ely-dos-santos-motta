@props(['name', 'type' => 'text', 'label' => '', 'placeholder' => '', 'value' => ''])
<div>
    <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
    </label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
        placeholder="{{ $placeholder }}" />
    <x-forms.validate name="{{ $name }}" />
</div>
