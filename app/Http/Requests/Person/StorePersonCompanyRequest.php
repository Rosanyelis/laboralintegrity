<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonCompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'nullable|string|max:13|unique:people,dni',
            'previous_dni' => 'nullable|string|max:13',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'age' => 'nullable|integer|min:0|max:120',
            'gender' => 'nullable|in:masculino,femenino,otro',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'last_name' => 'apellido',
            'dni' => 'cédula',
            'previous_dni' => 'cédula anterior',
            'birth_place' => 'lugar de nacimiento',
            'birth_date' => 'fecha de nacimiento',
            'age' => 'edad',
            'gender' => 'género',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres.',
            'dni.nullable' => 'La cédula es obligatoria.',
            'dni.unique' => 'Esta cédula ya está registrada.',
            'dni.max' => 'La cédula no puede tener más de 13 caracteres.',
            'previous_dni.nullable' => 'La cédula anterior es obligatoria.',
            'previous_dni.max' => 'La cédula anterior no puede tener más de 13 caracteres.',
            'birth_place.nullable' => 'El lugar de nacimiento es obligatorio.',
            'birth_place.max' => 'El lugar de nacimiento no puede tener más de 255 caracteres.',
            'birth_date.nullable' => 'La fecha de nacimiento es obligatoria.',
            'birth_date.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
        ];
    }
}
