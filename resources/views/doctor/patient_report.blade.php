<!DOCTYPE html>
<html>
<head>
    <title>Patient Report</title>
    <style>
    </style>
</head>
<body>
    <h1>{{ $patient->name }}</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Email</th>
                <th>Fecha de consulta</th>
                <th>Razon</th>
                <th>Medicamentos</th>
                <th>Signos vitales</th>
                <th>Notas</th>
                <th>Atendio una enfermera</th>
                <th>Precio total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicalInfos as $info)
                <tr>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $info->consultation_date }}</td>
                    <td>{{ $info->reason }}</td>
                    <td class="border px-4 py-2 max-w-xs truncate">
    @php
        $medicationsList = json_decode($info->medications, true);
    @endphp
    @if($medicationsList && is_array($medicationsList))
        <strong>Servicio:</strong> {{ $info->service ?? 'No service provided' }}<br>
        <strong>Medicamentos:</strong><br>
        @foreach($medicationsList as $medication)
            @if(isset($medication['name'], $medication['price'], $medication['quantity']))
                {{ $medication['name'] }} -> {{ $medication['quantity'] }}<br>
            @else
                Datos del medicamento incompletos
            @endif
        @endforeach
    @else
        No medications
    @endif
</td>

                    <td>
                        @php
                            $vitalSigns = json_decode($info->vital_signs, true);
                        @endphp
                        <ul>
                            <li>Temperature: {{ $vitalSigns['temperature'] ?? 'N/A' }} °C</li>
                            <li>Heart Rate: {{ $vitalSigns['heart_rate'] ?? 'N/A' }} bpm</li>
                            <li>Blood Pressure: {{ $vitalSigns['blood_pressure'] ?? 'N/A' }}</li>
                        </ul>
                    </td>
                    <td>{{ $info->notes }}</td>
                    <td>
                        {{ $info->nurse_attended ? 'Sí' : 'No' }}
                    </td>
                    <td>${{ number_format($info->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
