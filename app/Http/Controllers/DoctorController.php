<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('doctor.index');
    }

    public function getDoctorEvents()
    {
        $appointments = Appointment::with('patient')->get();
    
        $events = [];
        $now = \Carbon\Carbon::now();
    
        foreach ($appointments as $appointment) {
            $appointmentDateTime = \Carbon\Carbon::parse($appointment->date . ' ' . $appointment->time);
            $color = $appointmentDateTime->isPast() ? 'red' : 'blue';
    
            $events[] = [
                'id' => $appointment->id,
                'title' => 'Cita con ' . $appointment->patient->name,
                'start' => $appointment->date . 'T' . $appointment->time,
                'end' => $appointment->date . 'T' . $appointmentDateTime->addMinutes(30)->format('H:i'),
                'color' => $color,
                'extendedProps' => [
                    'patient_name' => $appointment->patient->name,
                    'patient_email' => $appointment->patient->email,
                ]
            ];
        }
    
        return response()->json($events);
    }
    
}
