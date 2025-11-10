<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permitir registro público
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Datos de la empresa
            'business_name' => 'required|string|max:255',
            'branch' => 'nullable|string|max:255',
            'rnc' => 'nullable|string|max:255|unique:companies,rnc',
            'industry' => 'nullable|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'sector' => 'nullable|string|max:255',
            'landline_phone' => ['nullable', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
            'extension' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            
            // Datos del representante
            'representative_name' => 'nullable|string|max:255',
            'representative_dni' => ['nullable', 'string', 'max:13', 'regex:/^\d{3}-\d{7}-\d{1}$/'],
            'representative_mobile' => ['nullable', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
            'representative_email' => 'nullable|email|max:255',
            
            // Datos de usuario
            'user_email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'business_name.required' => 'El nombre de la empresa es obligatorio.',
            'province_id.required' => 'La provincia es obligatoria.',
            'province_id.exists' => 'La provincia seleccionada no es válida.',
            'municipality_id.required' => 'El municipio es obligatorio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',
            'rnc.unique' => 'Ya existe una empresa registrada con este RNC.',
            'landline_phone.regex' => 'El formato del teléfono fijo debe ser: 0000-000-0000',
            'representative_dni.regex' => 'El formato de la cédula debe ser: 000-0000000-0',
            'representative_mobile.regex' => 'El formato del teléfono móvil debe ser: 0000-000-0000',
            'email.email' => 'El correo electrónico de la empresa debe ser una dirección válida.',
            'representative_email.email' => 'El correo electrónico del representante debe ser una dirección válida.',
            'user_email.required' => 'El correo electrónico para el usuario es obligatorio.',
            'user_email.email' => 'El correo electrónico debe ser una dirección válida.',
            'user_email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
