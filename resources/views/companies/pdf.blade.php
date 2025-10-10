<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Empresas</title>
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
        <h1>Reporte de Empresas</h1>
        <p>Listado de Empresas Registradas</p>
    </div>

    <div class="metadata">
        <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
        <p>Total de registros: {{ count($companies) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">CÓDIGO</th>
                <th style="width: 25%;">NOMBRE EMPRESA</th>
                <th style="width: 12%;">RNC</th>
                <th style="width: 15%;">PROVINCIA</th>
                <th style="width: 15%;">MUNICIPIO</th>
                <th style="width: 13%;">TELÉFONO</th>
                <th style="width: 10%;">REPRESENTANTE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <td>{{ $company['code_unique'] }}</td>
                <td>{{ $company['business_name'] }}</td>
                <td>{{ $company['rnc'] }}</td>
                <td>{{ $company['province'] }}</td>
                <td>{{ $company['municipality'] }}</td>
                <td>{{ $company['landline_phone'] }}</td>
                <td style="font-size: 8px;">{{ $company['representative_name'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-records">
        Total de empresas en el reporte: {{ count($companies) }}
    </div>

    <div class="footer">
        <p>Sistema de Gestión de Personal - Laboral Integrity</p>
        <p>Este documento es confidencial y solo debe ser usado para fines autorizados</p>
    </div>
</body>
</html>

