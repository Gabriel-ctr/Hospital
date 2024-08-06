<!-- resources/views/doctor/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Mis Citas</h2>
        <div id="calendar" class="mt-4"></div>
    </div>
</div>

<!-- Modal -->
<div id="appointmentModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-md w-full">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900" id="modalTitle"></div>
            <div class="mt-2">
                <p class="text-sm text-gray-500" id="modalBody"></p>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-100 text-right">
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" onclick="closeModal()">Cerrar</button>
        </div>
    </div>
</div>

<!-- FullCalendar CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/doctor/appointments/events',
        eventClick: function(info) {
            document.getElementById('modalTitle').innerText = info.event.title;
            document.getElementById('modalBody').innerHTML = `
                <p><strong>Paciente:</strong> ${info.event.extendedProps.patient_name}</p>
                <p><strong>Email:</strong> ${info.event.extendedProps.patient_email}</p>
            `;
            document.getElementById('appointmentModal').classList.remove('hidden');
            document.getElementById('appointmentModal').classList.add('flex');
        }
    });

    calendar.render();
});

function closeModal() {
    document.getElementById('appointmentModal').classList.add('hidden');
    document.getElementById('appointmentModal').classList.remove('flex');
}
</script>
@endsection
