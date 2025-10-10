<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Personal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #6b7280;
            font-size: 11px;
        }

        .metadata {
            margin-bottom: 20px;
            text-align: right;
            font-size: 9px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #f3f4f6;
        }

        th {
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            color: #374151;
            border-bottom: 2px solid #d1d5db;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody tr:hover {
            background-color: #f3f4f6;
        }

        td {
            padding: 6px 5px;
            font-size: 9px;
            color: #4b5563;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-yellow {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-blue {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-gray {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .total-records {
            margin-top: 10px;
            text-align: right;
            font-weight: bold;
            font-size: 10px;
            color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Personal Individual</h1>
        <p>Listado de Personas Registradas</p>
    </div>

    <div class="metadata">
        <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
        <p>Total de registros: {{ count($people) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">CÓDIGO</th>
                <th style="width: 25%;">NOMBRE COMPLETO</th>
                <th style="width: 12%;">CÉDULA</th>
                <th style="width: 8%;">EDAD</th>
                <th style="width: 10%;">TELÉFONO</th>
                <th style="width: 15%;">EMAIL</th>
                <th style="width: 10%;">VERIFICADO</th>
                <th style="width: 10%;">ESTATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
            <tr>
                <td>{{ $person['code_unique'] }}</td>
                <td>{{ $person['nombre_completo'] }}</td>
                <td>{{ $person['dni'] }}</td>
                <td>{{ $person['age'] }}</td>
                <td>{{ $person['cell_phone'] }}</td>
                <td style="font-size: 8px;">{{ $person['email'] }}</td>
                <td>
                    @php
                        $verificationClass = match($person['verification_status']) {
                            'certificado' => 'badge-green',
                            'parcial' => 'badge-yellow',
                            'pendiente' => 'badge-blue',
                            default => 'badge-gray'
                        };
                        $verificationLabel = match($person['verification_status']) {
                            'certificado' => 'Certificado',
                            'parcial' => 'Parcial',
                            'pendiente' => 'Pendiente',
                            'no_aplica' => 'No aplica',
                            default => 'N/A'
                        };
                    @endphp
                    <span class="badge {{ $verificationClass }}">{{ $verificationLabel }}</span>
                </td>
                <td>
                    @php
                        $statusClass = match($person['employment_status']) {
                            'disponible' => 'badge-green',
                            'en_proceso' => 'badge-blue',
                            'contratado' => 'badge-green',
                            'pendiente' => 'badge-yellow',
                            default => 'badge-gray'
                        };
                        $statusLabel = match($person['employment_status']) {
                            'disponible' => 'Disponible',
                            'en_proceso' => 'En proceso',
                            'contratado' => 'Contratado',
                            'pendiente' => 'Pendiente',
                            'part_time' => 'Part time',
                            'despido' => 'Despido',
                            'desaucio' => 'Desaucio',
                            'renuncia' => 'Renuncia',
                            'aplica' => 'Aplica',
                            'no_aplica' => 'No aplica',
                            default => 'N/A'
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-records">
        Total de personas en el reporte: {{ count($people) }}
    </div>

    <div class="footer">
        <p>Sistema de Gestión de Personal - Laboral Integrity</p>
        <p>Este documento es confidencial y solo debe ser usado para fines autorizados</p>
    </div>
</body>
</html>

