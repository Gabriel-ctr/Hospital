<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Doctor\MedicalInfoController;
use App\Http\Controllers\AppointmentController;
use App\Models\MedicalInfo;

// Middleware de autenticación
Route::middleware(['auth'])->group(function () {

    // Rutas para el admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    });

    Route::middleware(['auth', 'role:doctor'])->group(function () {
        Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.dashboard');
        Route::get('/doctor/appointments/events', [DoctorController::class, 'getDoctorEvents']);
        Route::get('get-appointments/{patientId}', [AppointmentController::class, 'getAppointments']);
  // Ruta para mostrar el formulario de registro de medicamentos
  Route::get('/doctor/medicines/create', [MedicalInfoController::class, 'createMedicine'])->name('doctor.medicines.create');

  // Ruta para almacenar los datos del formulario
  Route::post('/doctor/medicines', [MedicalInfoController::class, 'storeMedicine'])->name('doctor.medicines.store');    });
  Route::get('/api/medicines', [MedicalInfoController::class, 'getMedicines'])->name('doctor.medicines.list');
  Route::get('patients/{patient}/download-pdf', [PatientController::class, 'downloadPatientPDF'])->name('patients.downloadPDF');
  Route::get('/doctor/appointments/create', [AppointmentController::class, 'createForDoctor'])->name('doctor.appointments.create');
  Route::post('/doctor/appointments', [AppointmentController::class, 'storeForDoctor'])->name('doctor.appointments.store');
  Route::get('/doctor/appointments/patient/{patientId}/events', [AppointmentController::class, 'getAppointments']);
  Route::get('/doctor/appointments/doctor/{doctorId}/events', [AppointmentController::class, 'getDoctorEvents']);

  Route::get('doctor/services/create', [MedicalInfoController::class, 'createService'])->name('services.create');
  Route::post('/services', [MedicalInfoController::class, 'storeService'])->name('services.store');
  

    Route::prefix('doctor')->middleware(['auth', 'role:doctor'])->group(function () {
        Route::get('medical_infos/create', [MedicalInfoController::class, 'create'])->name('doctor.medical_infos.create');
        Route::post('medical_infos', [MedicalInfoController::class, 'store'])->name('doctor.medical_infos.store');
        Route::get('patients', [MedicalInfoController::class, 'index'])->name('doctor.patients.index');
    });

    // Rutas para el paciente
    Route::middleware('role:patient')->group(function () {
        Route::get('/patient', [PatientController::class, 'index'])->name('patient.dashboard');
        Route::get('/patient/medical_infos', [PatientController::class, 'medicalInfos'])->name('patient.medical_infos');
    });

 // Rutas para la secretaria
 Route::middleware('role:secretary')->group(function () {
    Route::get('/secretary', [SecretaryController::class, 'index'])->name('secretary.dashboard');
    Route::get('/secretary/appointments/create', [AppointmentController::class, 'create'])->name('secretary.appointments.create');
    Route::post('/secretary/appointments/store', [AppointmentController::class, 'store'])->name('secretary.appointments.store');
    Route::get('/secretary/appointments/{doctorId}/events', [AppointmentController::class, 'getDoctorEvents']);
});

    // Rutas para el perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta del dashboard, protegida por autenticación y verificación
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:secretary'])->group(function () {
    Route::get('secretary/appointments/create', [AppointmentController::class, 'create'])->name('secretary.appointments.create');
    Route::post('secretary/appointments', [AppointmentController::class, 'store'])->name('secretary.appointments.store');
});
require __DIR__.'/auth.php';
