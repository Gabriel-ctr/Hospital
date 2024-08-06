<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalInfo;
use App\Models\User;
use App\Models\Medicine;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicalInfoController extends Controller
{
    public function create(Request $request)
    {
        // Obtener pacientes
        $patients = User::where('role', 'patient')->get();
        $medications = Medicine::all(); // Obtiene todos los medicamentos
        $services = Service::all(); // Obtiene todos los servicios
        // Inicializar citas vacías
        $appointments = [];
    
        // Si hay un patient_id en la solicitud, obtener citas correspondientes
        if ($request->has('patient_id') && $request->input('patient_id')) {
            $patientId = $request->input('patient_id');
            $appointments = Appointment::where('patient_id', $patientId)->pluck('date');
        }
    
        return view('doctor.create_medical_info', compact('patients', 'appointments', 'medications', 'services'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'service' => 'string',
            'nurse_attended' => 'required|boolean',
            'temperature' => 'required|numeric',
            'heart_rate' => 'required|numeric',
            'blood_pressure' => 'required|string',
            'reason' => 'required|string',
            'medications' => 'nullable|array',
            'medication_quantities' => 'nullable|array',
            'medication_prices' => 'nullable|array',
            'notes' => 'nullable|string',
            'total_price' => 'required|numeric',
        ]);

        // Convertir la fecha de la cita a un objeto Carbon
        $appointmentDate = Carbon::parse($request->input('appointment_date'));
        // dd($appointmentDate);
        // Obtener la fecha y hora actual
        $now = Carbon::now();

        // Comparar si la fecha de la cita es anterior a la fecha y hora actual
        if ($appointmentDate->lt($now)) {
            return redirect()->back()->withErrors(['appointment_date' => 'La fecha de la cita no puede ser anterior a la fecha actual.'])->withInput();
        }


        // dd($request->all());
        $totalPrice = 0;
        $medicationsList = [];
        $errors = [];
        $medications = $request->input('medications', []);
        $quantities = $request->input('medication_quantities', []);
        $prices = $request->input('medication_prices', []);
    
        foreach ($medications as $key => $medicationId) {
            $price = $prices[$key] ?? 0;
            $quantity = $quantities[$key] ?? 0;
            $medication = Medicine::find($medicationId);
    
            if (!$medication) {
                $errors[] = "Medicamento con ID '$medicationId' no encontrado.";
                continue;
            }
    
            if ($medication->quantity < $quantity) {
                $errors[] = "Cantidad insuficiente del medicamento '$medication->name'. Disponible: $medication->quantity, Solicitado: $quantity.";
                continue;
            }
    
            $medicationsList[] = [
                'name' => $medication->name,
                'price' => $price,
                'quantity' => $quantity,
            ];
    
            $totalPrice += $price * $quantity;
    
            // Decrementar la cantidad en inventario
            $medication->decrement('quantity', $quantity);
        }
    
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }
    
        $medicalInfo = MedicalInfo::create([
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'service' => $request->service,
            'nurse_attended' => $request->input('nurse_attended'),
            'vital_signs' => json_encode([
                'temperature' => $request->temperature,
                'heart_rate' => $request->heart_rate,
                'blood_pressure' => $request->blood_pressure,
            ]),
            'reason' => $request->reason,
            'notes' => $request->notes,
            'consultation_date' => Carbon::now(),
            'medications' => json_encode($medicationsList),
            'total_price' => $request->total_price,
        ]);
        // dd($medicalInfo);
        return redirect()->route('doctor.dashboard')->with('success', 'Información médica añadida correctamente.');
    }
    

    public function index()
    {
        $patients = User::where('role', 'patient')->with('medicalInfos')->get();
    
        // Preparar datos para gráficos
        $consultationsByMonth = MedicalInfo::selectRaw('MONTH(consultation_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
    
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'
        ];
    
        // Calcular las edades de los pacientes
        $ages = $patients->map(function ($patient) {
            return \Carbon\Carbon::parse($patient->birthdate)->age;
        });
    
        // Agrupar edades en rangos
        $ageRanges = [
            '0-10' => 0,
            '11-20' => 0,
            '21-30' => 0,
            '31-40' => 0,
            '41-50' => 0,
            '51-60' => 0,
            '61-70' => 0,
            '71-80' => 0,
            '81-90' => 0,
            '91-100' => 0,
        ];
    
        foreach ($ages as $age) {
            if ($age <= 10) $ageRanges['0-10']++;
            elseif ($age <= 20) $ageRanges['11-20']++;
            elseif ($age <= 30) $ageRanges['21-30']++;
            elseif ($age <= 40) $ageRanges['31-40']++;
            elseif ($age <= 50) $ageRanges['41-50']++;
            elseif ($age <= 60) $ageRanges['51-60']++;
            elseif ($age <= 70) $ageRanges['61-70']++;
            elseif ($age <= 80) $ageRanges['71-80']++;
            elseif ($age <= 90) $ageRanges['81-90']++;
            else $ageRanges['91-100']++;
        }
    
        return view('doctor.patients', compact('patients', 'consultationsByMonth', 'months', 'ageRanges'));
    }

    // Método para mostrar el formulario de registro de medicamentos
    public function createMedicine()
    {
        return view('doctor.register_medicine');
    }

    // Método para almacenar los datos del formulario
    public function storeMedicine(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        Medicine::create([
            'name' => $request->input('name'),
            'quantity' => $request->input('quantity'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('doctor.medicines.create')->with('success', 'Medicamento registrado exitosamente.');
    }

    // Método para obtener los medicamentos
    public function getMedicines()
    {
        $medicines = Medicine::all(['id', 'name', 'price']);
        return response()->json($medicines);
    }


    // Para registrar servicios
    public function createService()
    {
        return view('doctor.register_services');
    }

    // Guardar el nuevo servicio en la base de datos
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('services.create')->with('success', 'Servicio registrado con éxito.');
    }
}
