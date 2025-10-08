<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permitir a usuarios autenticados actualizar personas
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $personId = $this->route('person')->id ?? $this->route('person');
        
        return [
            // Campos obligatorios
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('people')->ignore($personId)],
            'dni' => ['required', 'string', 'max:20', Rule::unique('people')->ignore($personId)],
            'country' => 'required|string|max:100',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            
            // Campos opcionales
            'cell_phone' => 'nullable|string|max:20',
            'home_phone' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:120',
            'marital_status' => 'nullable|in:soltero,casado,viudo',
            'previous_dni' => 'nullable|string|max:20',
            'gender' => 'nullable|in:masculino,femenino,otro',
            'zip_code' => 'nullable|string|max:10',
            'social_media_1' => 'nullable|string|max:255',
            'social_media_2' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'medication_allergies' => 'nullable|string',
            'illnesses' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'other_emergency_contacts' => 'nullable|string',
            'position_applied_for' => 'nullable|string|max:255',
            'company_code' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:pendiente,parcial,no_aplica,certificado',
            'employment_status' => 'nullable|in:pendiente,disponible,en_proceso,contratado,part_time,despido,desaucio,renuncia,aplica,no_aplica',
            
            // Campos de residencia
            'district_id' => 'nullable',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'sector' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street_and_number' => 'nullable|string|max:255',
            'arrival_reference' => 'nullable|string|max:255',
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
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dni.required' => 'La cédula es obligatoria.',
            'dni.unique' => 'Esta cédula ya está registrada.',
            'dni.max' => 'La cédula no puede tener más de 20 caracteres.',
            'country.required' => 'El país es obligatorio.',
            'birth_place.required' => 'El lugar de nacimiento es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'birth_date.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad no puede ser menor a 0.',
            'age.max' => 'La edad no puede ser mayor a 120.',
            'marital_status.in' => 'El estado civil debe ser: soltero, casado o viudo.',
            'gender.in' => 'El género debe ser: masculino, femenino u otro.',
            'verification_status.in' => 'El estado de verificación debe ser: pendiente, parcial, no_aplica o certificado.',
            'employment_status.in' => 'El estado de empleo debe ser uno de los valores permitidos.',
            'municipality_id.exists' => 'El municipio seleccionado no existe.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'last_name' => 'apellido',
            'email' => 'correo electrónico',
            'dni' => 'cédula',
            'previous_dni' => 'cédula anterior',
            'country' => 'país',
            'birth_place' => 'lugar de nacimiento',
            'birth_date' => 'fecha de nacimiento',
            'age' => 'edad',
            'marital_status' => 'estado civil',
            'gender' => 'género',
            'cell_phone' => 'teléfono celular',
            'home_phone' => 'teléfono fijo',
            'blood_type' => 'tipo de sangre',
            'medication_allergies' => 'alergias a medicamentos',
            'illnesses' => 'enfermedades',
            'emergency_contact_name' => 'contacto de emergencia',
            'emergency_contact_phone' => 'teléfono de emergencia',
            'position_applied_for' => 'ocupación',
            'company_code' => 'código de empresa',
            'company_name' => 'nombre de empresa',
            'verification_status' => 'estado de verificación',
            'employment_status' => 'estado de empleo',
            'district_id' => 'distrito',
            'municipality_id' => 'municipio',
            'sector' => 'sector',
            'neighborhood' => 'barrio',
            'street_and_number' => 'calle y número',
            'arrival_reference' => 'referencia de llegada',
        ];
    }
}
