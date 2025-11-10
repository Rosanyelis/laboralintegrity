<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $person->name }} {{ $person->last_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1173d4;
        }

        .photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 30px;
            border: 3px solid #1173d4;
        }

        .header-info {
            flex: 1;
        }

        .header-info h1 {
            color: #1173d4;
            font-size: 28px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .header-info p {
            color: #666;
            font-size: 12px;
            margin: 3px 0;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            color: #1173d4;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #1173d4;
            text-transform: uppercase;
        }

        .section-content {
            font-size: 11px;
            color: #444;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        .list-item {
            margin-bottom: 15px;
            padding-left: 20px;
            position: relative;
        }

        .list-item::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #1173d4;
            font-weight: bold;
        }

        .experience-item, .education-item, .reference-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-left: 4px solid #1173d4;
        }

        .experience-item h4, .education-item h4, .reference-item h4 {
            color: #1173d4;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .experience-item p, .education-item p, .reference-item p {
            margin: 5px 0;
            font-size: 11px;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media print {
            body {
                padding: 15px;
            }
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- Header con Foto y Datos Básicos -->
    <div class="header">
        @if($person->profile_photo && Storage::disk('public')->exists($person->profile_photo))
            <img src="{{ public_path('storage/' . $person->profile_photo) }}" alt="Foto de Perfil" class="photo">
        @else
            <div class="photo" style="background-color: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 12px; text-align: center;">
                Sin Foto
            </div>
        @endif
        <div class="header-info">
            <h1>{{ $person->name }} {{ $person->last_name }}</h1>
            <p><strong>Código Único:</strong> {{ $person->code_unique ?? 'N/A' }}</p>
            <p><strong>Cédula:</strong> {{ $person->dni ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $person->email ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $person->cell_phone ?? 'N/A' }}</p>
            @if($person->residenceInformation)
                <p><strong>Ubicación:</strong> 
                    {{ $person->residenceInformation->municipality?->name ?? '' }}, 
                    {{ $person->residenceInformation->province?->name ?? '' }}
                </p>
            @endif
        </div>
    </div>

    <!-- Información Personal -->
    <div class="section">
        <h2 class="section-title">Información Personal</h2>
        <div class="section-content">
            <div class="two-column">
                <div>
                    <div class="info-grid">
                        <span class="info-label">Fecha de Nacimiento:</span>
                        <span class="info-value">{{ $person->birth_date ? $person->birth_date->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="info-grid">
                        <span class="info-label">Edad:</span>
                        <span class="info-value">{{ $person->age ?? 'N/A' }} años</span>
                    </div>
                    <div class="info-grid">
                        <span class="info-label">Lugar de Nacimiento:</span>
                        <span class="info-value">{{ $person->birth_place ?? 'N/A' }}</span>
                    </div>
                    <div class="info-grid">
                        <span class="info-label">Nacionalidad:</span>
                        <span class="info-value">{{ $person->country ?? 'N/A' }}</span>
                    </div>
                    <div class="info-grid">
                        <span class="info-label">Género:</span>
                        <span class="info-value">{{ ucfirst($person->gender ?? 'N/A') }}</span>
                    </div>
                    <div class="info-grid">
                        <span class="info-label">Estado Civil:</span>
                        <span class="info-value">{{ ucfirst($person->marital_status ?? 'N/A') }}</span>
                    </div>
                </div>
                <div>
                    <div class="info-grid">
                        <span class="info-label">Teléfono Fijo:</span>
                        <span class="info-value">{{ $person->home_phone ?? 'N/A' }}</span>
                    </div>
                    @if($person->social_media_1)
                    <div class="info-grid">
                        <span class="info-label">Red Social 1:</span>
                        <span class="info-value">{{ $person->social_media_1 }}</span>
                    </div>
                    @endif
                    @if($person->social_media_2)
                    <div class="info-grid">
                        <span class="info-label">Red Social 2:</span>
                        <span class="info-value">{{ $person->social_media_2 }}</span>
                    </div>
                    @endif
                    <div class="info-grid">
                        <span class="info-label">Tipo de Sangre:</span>
                        <span class="info-value">{{ $person->blood_type ?? 'N/A' }}</span>
                    </div>
                    @if($person->medication_allergies)
                    <div class="info-grid">
                        <span class="info-label">Alergias:</span>
                        <span class="info-value">{{ $person->medication_allergies }}</span>
                    </div>
                    @endif
                    @if($person->illnesses)
                    <div class="info-grid">
                        <span class="info-label">Enfermedades:</span>
                        <span class="info-value">{{ $person->illnesses }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Residencia -->
    @if($person->residenceInformation)
    <div class="section">
        <h2 class="section-title">Información de Residencia</h2>
        <div class="section-content">
            <div class="info-grid">
                <span class="info-label">Regional:</span>
                <span class="info-value">{{ $person->residenceInformation->province?->regional?->name ?? 'N/A' }}</span>
            </div>
            <div class="info-grid">
                <span class="info-label">Provincia:</span>
                <span class="info-value">{{ $person->residenceInformation->province?->name ?? 'N/A' }}</span>
            </div>
            <div class="info-grid">
                <span class="info-label">Municipio:</span>
                <span class="info-value">{{ $person->residenceInformation->municipality?->name ?? 'N/A' }}</span>
            </div>
            @if($person->residenceInformation->district)
            <div class="info-grid">
                <span class="info-label">Distrito:</span>
                <span class="info-value">{{ $person->residenceInformation->district->name }}</span>
            </div>
            @endif
            @if($person->residenceInformation->sector)
            <div class="info-grid">
                <span class="info-label">Sector:</span>
                <span class="info-value">{{ $person->residenceInformation->sector }}</span>
            </div>
            @endif
            @if($person->residenceInformation->neighborhood)
            <div class="info-grid">
                <span class="info-label">Barrio:</span>
                <span class="info-value">{{ $person->residenceInformation->neighborhood }}</span>
            </div>
            @endif
            @if($person->residenceInformation->street_and_number)
            <div class="info-grid">
                <span class="info-label">Calle y Número:</span>
                <span class="info-value">{{ $person->residenceInformation->street_and_number }}</span>
            </div>
            @endif
            @if($person->residenceInformation->arrival_reference)
            <div class="info-grid">
                <span class="info-label">Referencia de Llegada:</span>
                <span class="info-value">{{ $person->residenceInformation->arrival_reference }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Contacto de Emergencia -->
    <div class="section">
        <h2 class="section-title">Contacto de Emergencia</h2>
        <div class="section-content">
            <div class="info-grid">
                <span class="info-label">Nombre:</span>
                <span class="info-value">{{ $person->emergency_contact_name ?? 'N/A' }}</span>
            </div>
            <div class="info-grid">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $person->emergency_contact_phone ?? 'N/A' }}</span>
            </div>
            @if($person->other_emergency_contacts)
            <div class="info-grid">
                <span class="info-label">Otros Contactos:</span>
                <span class="info-value">{{ $person->other_emergency_contacts }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Habilidades Educativas -->
    @if($person->educationalSkills && $person->educationalSkills->count() > 0)
    <div class="section">
        <h2 class="section-title">Habilidades Educativas</h2>
        <div class="section-content">
            @foreach($person->educationalSkills as $skill)
            <div class="education-item">
                <h4>{{ $skill->career }}</h4>
                <p><strong>Centro Educativo:</strong> {{ $skill->educational_center }}</p>
                <p><strong>Año de Graduación:</strong> {{ $skill->year }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Experiencias Laborales -->
    @if($person->workExperiences && $person->workExperiences->count() > 0)
    <div class="section">
        <h2 class="section-title">Experiencias Laborales</h2>
        <div class="section-content">
            @foreach($person->workExperiences as $experience)
            <div class="experience-item">
                <h4>{{ $experience->position }}</h4>
                <p><strong>Empresa:</strong> {{ $experience->company_name }}</p>
                <p><strong>Período:</strong> {{ $experience->year_range }}</p>
                @if($experience->achievements)
                <p><strong>Logros:</strong> {{ $experience->achievements }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Referencias Personales -->
    @if($person->personalReferences && $person->personalReferences->count() > 0)
    <div class="section">
        <h2 class="section-title">Referencias Personales</h2>
        <div class="section-content">
            @foreach($person->personalReferences as $reference)
            <div class="reference-item">
                <h4>{{ $reference->full_name }}</h4>
                <p><strong>Relación:</strong> {{ ucfirst($reference->relationship) }}</p>
                <p><strong>Cédula:</strong> {{ $reference->cedula }}</p>
                <p><strong>Teléfono:</strong> {{ $reference->cell_phone }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Aspiraciones -->
    @if($person->aspiration)
    <div class="section">
        <h2 class="section-title">Aspiraciones Laborales</h2>
        <div class="section-content">
            <div class="info-grid">
                <span class="info-label">Posición Deseada:</span>
                <span class="info-value">{{ $person->aspiration->desired_position ?? 'N/A' }}</span>
            </div>
            <div class="info-grid">
                <span class="info-label">Sector de Interés:</span>
                <span class="info-value">{{ $person->aspiration->sector_of_interest ?? 'N/A' }}</span>
            </div>
            <div class="info-grid">
                <span class="info-label">Salario Esperado:</span>
                <span class="info-value">
                    @if($person->aspiration->expected_salary)
                        ${{ number_format($person->aspiration->expected_salary, 2) }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
            <div class="info-grid">
                <span class="info-label">Tipo de Contrato Preferido:</span>
                <span class="info-value">
                    @if($person->aspiration->contract_type_preference)
                        {{ ucfirst(str_replace('_', ' ', $person->aspiration->contract_type_preference)) }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
            <div class="info-grid">
                <span class="info-label">Estatus Laboral:</span>
                <span class="info-value">{{ ucfirst($person->aspiration->employment_status ?? 'N/A') }}</span>
            </div>
            <div class="info-grid">
                <span class="info-label">Alcance Laboral:</span>
                <span class="info-value">{{ ucfirst($person->aspiration->work_scope ?? 'N/A') }}</span>
            </div>
            @if($person->aspiration->short_term_goals)
            <div class="info-grid">
                <span class="info-label">Metas a Corto Plazo:</span>
                <span class="info-value">{{ $person->aspiration->short_term_goals }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #9ca3af; font-size: 9px;">
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }} - Integridad Laboral</p>
    </div>
</body>
</html>

