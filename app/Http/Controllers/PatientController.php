<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalInfo;
use Dompdf\Dompdf;
use Dompdf\Options;    
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $medicalInfos = MedicalInfo::where('patient_id', Auth::id())->get();
        return view('patient.index', compact('medicalInfos'));
    }
    

    public function medicalInfos()
    {
        $medicalInfos = MedicalInfo::where('patient_id', Auth::id())->get();
        return view('patient.medical_infos', compact('medicalInfos'));
    }



    public function downloadPatientPDF($patientId)
    {
        $patient = User::with('medicalInfos')->findOrFail($patientId);
        $medicalInfos = $patient->medicalInfos;
    
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf->setOptions($options);
    
        $html = view('doctor.patient_report', compact('patient', 'medicalInfos'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream('patient_report_' . $patient->name . '.pdf', ['Attachment' => 1]);
    }

}
