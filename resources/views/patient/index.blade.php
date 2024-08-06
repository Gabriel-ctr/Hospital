@extends('layouts.app') {{-- Asumiendo que la plantilla está en layouts/app.blade.php --}}

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Bienvenido, Paciente</h1>
        <p class="mb-4">Aqui encontraras registros sobre tus consultas.</p>

        <!-- Tabla de servicios y medicamentos -->
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 px-4 py-2">Servicio y Medicamentos</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($medicalInfos as $info)
                    <tr>
                        <td class="border px-4 py-2 max-w-xs truncate">
                            @php
                                $medicationsList = json_decode($info->medications, true);
                            @endphp
                            <strong>Servicio:</strong> {{ $info->service ?? 'No service provided' }}<br>
                            <strong>Medicamentos:</strong><br>
                            @if($medicationsList && is_array($medicationsList))
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
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
