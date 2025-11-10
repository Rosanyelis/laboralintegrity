<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePersonRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Público, no requiere autenticación
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Información Personal
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => ['required', 'string', 'max:13', 'regex:/^\d{3}-\d{7}-\d{1}$/', 'unique:people,dni'],
            'previous_dni' => ['nullable', 'string', 'max:13', 'regex:/^\d{3}-\d{7}-\d{1}$/'],
            'gender' => 'nullable|in:masculino,femenino,otro',
            'country' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'age' => 'nullable|integer|min:0|max:120',
            'marital_status' => 'nullable|in:soltero,casado,viudo',
            'email' => 'required|email|max:255|unique:people,email|unique:users,email',
            'cell_phone' => ['required', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
            'home_phone' => ['nullable', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
            'social_media_1' => 'nullable|string|max:255',
            'social_media_2' => 'nullable|string|max:255',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'medication_allergies' => 'nullable|string|max:500',
            'illnesses' => 'nullable|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => ['required', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
            'other_emergency_contacts' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
            
            // Información Residencial
            'municipality_id' => 'required|exists:municipalities,id',
            'district_id' => 'nullable',
            'sector' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'street_and_number' => 'nullable|string|max:500',
            'arrival_reference' => 'nullable|string|max:500',
            
            // Habilidades Educativas (array)
            'educational_skills' => 'nullable|array',
            'educational_skills.*.career' => 'required_with:educational_skills|string|max:255',
            'educational_skills.*.educational_center' => 'required_with:educational_skills|string|max:255',
            'educational_skills.*.year' => 'required_with:educational_skills|integer|min:1900|max:' . (date('Y') + 10),
            
            // Experiencias Laborales (array)
            'work_experiences' => 'nullable|array',
            'work_experiences.*.company_name' => 'required_with:work_experiences|string|max:255',
            'work_experiences.*.position' => 'required_with:work_experiences|string|max:255',
            'work_experiences.*.year_range' => 'required_with:work_experiences|string|max:50',
            'work_experiences.*.achievements' => 'nullable|string|max:2000',
            
            // Referencias Personales (array, mínimo 1)
            'personal_references' => 'required|array|min:1',
            'personal_references.*.relationship' => 'required|in:padre,madre,conyuge,hermano,tio,amigo,otros',
            'personal_references.*.full_name' => 'required|string|max:255',
            'personal_references.*.cedula' => ['required', 'string', 'max:13', 'regex:/^\d{3}-\d{7}-\d{1}$/'],
            'personal_references.*.cell_phone' => ['required', 'string', 'max:13', 'regex:/^\d{4}-\d{3}-\d{4}$/'],
            
            // Aspiraciones
            'desired_position' => 'nullable|string|max:255',
            'sector_of_interest' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'contract_type_preference' => 'nullable|in:tiempo_completo,medio_tiempo,remoto,hibrido',
            'short_term_goals' => 'nullable|string|max:1000',
            'employment_status' => 'required|in:contratado,disponible,en_proceso,discapacitado,fallecido',
            'work_scope' => 'required|in:provincial,nacional',
            
            // Usuario
            'password' => 'required|string|min:8|confirmed',
            'terms_accepted' => 'required|accepted',
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
            // Información Personal
            'name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'Los apellidos son obligatorios.',
            'dni.required' => 'La cédula es obligatoria.',
            'dni.regex' => 'El formato de la cédula debe ser: 000-0000000-0',
            'dni.unique' => 'Esta cédula ya está registrada.',
            'previous_dni.regex' => 'El formato de la cédula anterior debe ser: 000-0000000-0',
            'gender.in' => 'El género seleccionado no es válido.',
            'country.required' => 'La nacionalidad es obligatoria.',
            'birth_place.required' => 'El lugar de nacimiento es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'marital_status.in' => 'El estado civil seleccionado no es válido.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'cell_phone.required' => 'El teléfono móvil es obligatorio.',
            'cell_phone.regex' => 'El formato del teléfono debe ser: 0000-000-0000',
            'home_phone.regex' => 'El formato del teléfono debe ser: 0000-000-0000',
            'blood_type.in' => 'El tipo de sangre seleccionado no es válido.',
            'emergency_contact_name.required' => 'El nombre del contacto de emergencia es obligatorio.',
            'emergency_contact_phone.required' => 'El teléfono del contacto de emergencia es obligatorio.',
            'emergency_contact_phone.regex' => 'El formato del teléfono debe ser: 0000-000-0000',
            'profile_photo.image' => 'La foto de perfil debe ser una imagen.',
            'profile_photo.mimes' => 'La foto de perfil debe ser JPG, PNG o GIF.',
            'profile_photo.max' => 'La foto de perfil no puede ser mayor a 800KB.',
            
            // Información Residencial
            'municipality_id.required' => 'Debe seleccionar un municipio.',
            'municipality_id.exists' => 'El municipio seleccionado no existe.',
            
            // Habilidades Educativas
            'educational_skills.*.career.required_with' => 'El nombre de la carrera es obligatorio.',
            'educational_skills.*.educational_center.required_with' => 'El centro educativo es obligatorio.',
            'educational_skills.*.year.required_with' => 'El año de graduación es obligatorio.',
            'educational_skills.*.year.integer' => 'El año debe ser un número válido.',
            'educational_skills.*.year.min' => 'El año debe ser mayor a 1900.',
            'educational_skills.*.year.max' => 'El año no puede ser mayor a ' . (date('Y') + 10) . '.',
            
            // Experiencias Laborales
            'work_experiences.*.company_name.required_with' => 'El nombre de la empresa es obligatorio.',
            'work_experiences.*.position.required_with' => 'La posición es obligatoria.',
            'work_experiences.*.year_range.required_with' => 'El rango de años es obligatorio.',
            
            // Referencias Personales
            'personal_references.required' => 'Debe agregar al menos una referencia personal.',
            'personal_references.min' => 'Debe agregar al menos una referencia personal.',
            'personal_references.*.relationship.required' => 'La relación es obligatoria.',
            'personal_references.*.relationship.in' => 'La relación seleccionada no es válida.',
            'personal_references.*.full_name.required' => 'El nombre completo es obligatorio.',
            'personal_references.*.cedula.required' => 'La cédula es obligatoria.',
            'personal_references.*.cedula.regex' => 'El formato de la cédula debe ser: 000-0000000-0',
            'personal_references.*.cell_phone.required' => 'El teléfono celular es obligatorio.',
            'personal_references.*.cell_phone.regex' => 'El formato del teléfono debe ser: 0000-000-0000',
            
            // Aspiraciones
            'employment_status.required' => 'El estatus laboral es obligatorio.',
            'employment_status.in' => 'El estatus laboral seleccionado no es válido.',
            'work_scope.required' => 'El alcance laboral es obligatorio.',
            'work_scope.in' => 'El alcance laboral seleccionado no es válido.',
            'expected_salary.numeric' => 'El salario esperado debe ser un número válido.',
            'expected_salary.min' => 'El salario esperado debe ser mayor o igual a 0.',
            'contract_type_preference.in' => 'El tipo de contrato seleccionado no es válido.',
            
            // Usuario
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'terms_accepted.required' => 'Debe aceptar los términos y condiciones.',
            'terms_accepted.accepted' => 'Debe aceptar los términos y condiciones.',
        ];
    }
}

