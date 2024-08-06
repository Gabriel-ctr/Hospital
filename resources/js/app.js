import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            events: [
                // Aquí puedes añadir eventos de ejemplo
                {
                    title: 'Event 1',
                    start: '2024-07-01'
                },
                {
                    title: 'Event 2',
                    start: '2024-07-02'
                }
            ],
            dateClick: function(info) {
                alert('Date: ' + info.dateStr);
            },
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
            }
        });

        calendar.render();
    }
});
