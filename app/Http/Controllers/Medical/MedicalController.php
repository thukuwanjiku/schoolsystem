<?php

namespace App\Http\Controllers\Medical;

use App\DB\Medical\MedicalReport;
use App\DB\Students\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalController extends Controller
{
    public function index()
    {
        //fetch all reports entered by the logged in nurse
        $reports = MedicalReport::latest()->where('nurse_id', auth()->id())->get();

        return view('medical.medical_report')->with([
            'reports' => $reports
        ]);
    }

    public function newMedicalReport()
    {
        return view('medical.new_medical_report');
    }

    public function saveMedicalReport(Request $request)
    {
        //validate request
        $validation = $request->validate([
            'student_admission' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
        ], [
            'student_admission.required' => "Please enter the student admission number",
            'diagnosis.required' => "Please enter the diagnosis",
            'prescription_id.required' => "Please enter the prescription",
        ]);

        //get the student using the admission
        if(!$student = Student::where('admission_no', $request['student_admission'])->first()){
            return back()->withInput()->withErrors("No student with that Admission No.");
        }

        //create new medical report entry
        MedicalReport::create([
            'student_id' => $student->id,
            'nurse_id' => auth()->id(),
            'diagnosis' => $request['diagnosis'],
            'prescription' => $request['prescription'],
        ]);

        session()->flash('success', "Successfully saved medical report");
        return redirect()->route('medical');
    }
}
