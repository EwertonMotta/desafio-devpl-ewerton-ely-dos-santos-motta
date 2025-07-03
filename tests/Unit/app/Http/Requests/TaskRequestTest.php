<?php

declare(strict_types = 1);

namespace Tests\Unit\app\Http\Requests;

use App\Http\Requests\TaskRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('task request authorizes all users', function (): void {
    $request = new TaskRequest();

    expect($request->authorize())->toBeTrue();
});

test('task request has correct validation rules', function (): void {
    $request = new TaskRequest();

    expect($request->rules())->toBe([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'completed'   => 'boolean',
        'deadline'    => 'nullable|date|after_or_equal:today',
    ]);
});

test('task request has custom error messages', function (): void {
    $request = new TaskRequest();

    expect($request->messages())->toMatchArray([
        'title.required'          => 'O título é obrigatório.',
        'title.string'            => 'O título deve ser uma string.',
        'title.max'               => 'O título não pode ter mais de 255 caracteres.',
        'description.string'      => 'A descrição deve ser uma string.',
        'description.max'         => 'A descrição não pode ter mais de 1000 caracteres.',
        'completed.boolean'       => 'O status de conclusão deve ser verdadeiro ou falso.',
        'deadline.date'           => 'O prazo deve ser uma data válida.',
        'deadline.after_or_equal' => 'O prazo deve ser hoje ou uma data futura.',
    ]);
});

test('title is required', function (): void {
    $validator = Validator::make(
        ['title' => ''],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('title'))->toBe('O título é obrigatório.');
});

test('title must be a string', function (): void {
    $validator = Validator::make(
        ['title' => 123],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('title'))->toBe('O título deve ser uma string.');
});

test('title max length is 255', function (): void {
    $validator = Validator::make(
        ['title' => str_repeat('a', 256)],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('title'))->toBe('O título não pode ter mais de 255 caracteres.');
});

test('description must be a string if provided', function (): void {
    $validator = Validator::make(
        ['title' => 'Valid Title', 'description' => 123],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('description'))->toBe('A descrição deve ser uma string.');
});

test('description max length is 1000', function (): void {
    $validator = Validator::make(
        ['title' => 'Valid Title', 'description' => str_repeat('a', 1001)],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('description'))->toBe('A descrição não pode ter mais de 1000 caracteres.');
});

test('completed must be boolean', function (): void {
    $validator = Validator::make(
        ['title' => 'Valid Title', 'completed' => 'not-a-boolean'],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('completed'))->toBe('O status de conclusão deve ser verdadeiro ou falso.');
});

test('deadline must be a valid date', function (): void {
    $validator = Validator::make(
        ['title' => 'Valid Title', 'deadline' => 'not-a-date'],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('deadline'))->toBe('O prazo deve ser uma data válida.');
});

test('deadline must be today or future date', function (): void {
    $validator = Validator::make(
        ['title' => 'Valid Title', 'deadline' => now()->subDay()->format('Y-m-d')],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('deadline'))->toBe('O prazo deve ser hoje ou uma data futura.');
});

test('valid data passes validation', function (): void {
    $validator = Validator::make(
        [
            'title'       => 'Valid Title',
            'description' => 'Valid description',
            'completed'   => true,
            'deadline'    => now()->addDay()->format('Y-m-d'),
        ],
        (new TaskRequest())->rules(),
        (new TaskRequest())->messages()
    );

    expect($validator->fails())->toBeFalse();
});
