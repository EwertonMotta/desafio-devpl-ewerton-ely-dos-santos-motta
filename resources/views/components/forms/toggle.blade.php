@props(['name', 'label' => '', 'checked' => false])
<div class="flex flex-col items-center justify-center pt-3.5">
    <div class="flex items-center pt-3.5 lg:justify-center">
        <label class="me-5 inline-flex cursor-pointer items-center">
            <span class="me-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $label }}</span>
            <input type="checkbox" value="1" class="peer sr-only" name="{{ $name }}" id="{{ $name }}"
                @checked($checked) {{ $attributes }} />
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
