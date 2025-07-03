<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'completed'   => 'boolean',
            'deadline'    => 'nullable|date|after_or_equal:today',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required'          => 'O título é obrigatório.',
            'title.string'            => 'O título deve ser uma string.',
            'title.max'               => 'O título não pode ter mais de 255 caracteres.',
            'description.string'      => 'A descrição deve ser uma string.',
            'description.max'         => 'A descrição não pode ter mais de 1000 caracteres.',
            'completed.boolean'       => 'O status de conclusão deve ser verdadeiro ou falso.',
            'deadline.date'           => 'O prazo deve ser uma data válida.',
            'deadline.after_or_equal' => 'O prazo deve ser hoje ou uma data futura.',
        ];
    }
}
