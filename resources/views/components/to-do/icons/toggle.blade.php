@props(['task'])
<label class="me-5 flex cursor-pointer flex-col items-center justify-center">
    <span
        class="{{ $task->completed ? 'font-semibold text-green-600' : '' }} mb-1 text-sm text-gray-900 dark:text-gray-300">
        @if ($task->completed)
            Concluído
        @else
            Pendente
        @endif
    </span>
    <input type="checkbox" value="" class="peer sr-only" name="completed"
        onChange="document.getElementById('toggle-task-{{ $task->id }}').submit()" id="completed"
        @checked($task->completed) />
    <div
        class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-green-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-green-600 dark:peer-focus:ring-green-800">
    </div>
</label>
