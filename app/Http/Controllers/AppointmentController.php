<?php
// app/Http/Controllers/AppointmentController.php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        $patients = User::where('role', 'patient')->get();
        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function createForDoctor()
    {
        // Obtener la lista de doctores
        $doctors = User::where('role', 'doctor')->get();

        // Obtener la lista de pacientes
        $patients = User::where('role', 'patient')->get();

        return view('doctor.appointment', compact('doctors', 'patients'));
    }
    public function store(Request $request)
    {
        return $this->storeAppointment($request);
    }

    public function storeForDoctor(Request $request)
    {
        return $this->storeAppointmentDoctor($request);
    }

    protected function storeAppointmentDoctor(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'topic' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'date' => $request->date,
            'time' => $request->time,
            'subject' => $request->topic,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Cita agendada exitosamente');
    }

    protected function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'topic' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'date' => $request->date,
            'time' => $request->time,
            'subject' => $request->topic,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('secretary.dashboard')->with('success', 'Cita agendada exitosamente');
    }

    public function getDoctorEvents($doctorId)
    {
        $appointments = Appointment::where('doctor_id', $doctorId)->get(['id', 'patient_id', 'date', 'time']);
        $events = [];
    
        foreach ($appointments as $appointment) {
            $startTime = \Carbon\Carbon::parse($appointment->date . 'T' . $appointment->time);
            $endTime = $startTime->copy()->addMinutes(30);
            $isPast = \Carbon\Carbon::now()->greaterThan($endTime);
    
            $events[] = [
                'title' => 'Cita con ' . $appointment->patient->name,
                'start' => $startTime->format('Y-m-d\TH:i:s'),
                'end' => $endTime->format('Y-m-d\TH:i:s'),
                'color' => $isPast ? 'red' : 'blue', // Cambia el color si la cita ya pasó
                'is_past' => $isPast, // Añade el campo is_past para referencia en el frontend
            ];
        }
    
        return response()->json($events);
    }
    

    public function getAppointments($patientId)
    {
        try {
            $appointments = Appointment::where('patient_id', $patientId)
                ->get(['date', 'time']);
    
            // Return only date and time as strings
            $appointmentsFormatted = $appointments->map(function ($appointment) {
                return [
                    'dateTime' => $appointment->date . ' ' . $appointment->time, // Customize as needed
                ];
            });
    
            return response()->json($appointmentsFormatted);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
    
    
}
