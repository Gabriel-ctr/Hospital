@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Tus Citas y Signos Vitales</h1>
        <p class="mb-4">Aquí puedes ver tus citas y los signos vitales que han sido registrados por tu doctor.</p>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Fecha de Consulta</th>
                        <th class="py-2 px-4 border-b">Signos Vitales</th>
                        <th class="py-2 px-4 border-b">Motivo</th>
                        <th class="py-2 px-4 border-b">Medicamentos y Servicios</th>
                        <th class="py-2 px-4 border-b">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalInfos as $info)
                        @php
                            $vitalSigns = json_decode($info->vital_signs, true);
                            $medicationsList = json_decode($info->medications, true);
                        @endphp
                        <tr>
                            <td class="border px-4 py-2">{{ $info->consultation_date }}</td>
                            <td class="border px-4 py-2">
                                <ul>
                                    <li>Temperatura: {{ $vitalSigns['temperature'] ?? 'N/A' }} °C</li>
                                    <li>Frecuencia Cardíaca: {{ $vitalSigns['heart_rate'] ?? 'N/A' }} bpm</li>
                                    <li>Presión Arterial: {{ $vitalSigns['blood_pressure'] ?? 'N/A' }}</li>
                                </ul>
                            </td>
                            <td class="border px-4 py-2">{{ $info->reason }}</td>
                            <td class="border px-4 py-2 max-w-xs truncate">
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
                            <td class="border px-4 py-2">{{ $info->notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
