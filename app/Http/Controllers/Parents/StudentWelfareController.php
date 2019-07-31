<?php

namespace App\Http\Controllers\Parents;

use App\DB\Discpline\DisciplineCase;
use App\DB\Medical\MedicalReport;
use App\DB\Students\StudentsRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentWelfareController extends Controller
{
    public function index()
    {
        //get days student was absent
        $absentDates = StudentsRegister::latest()->where([
            'student_id' => session()->get('parent_auth')->student_id,
            'is_present' => false
        ])->get();

        //fetch discipline cases
        $disciplineCases = DisciplineCase::latest()->where('student_id', session()->get('parent_auth')->student_id)->get();

        //fetch medical report
        $medicalHistory = MedicalReport::latest()->where('student_id', session()->get('parent_auth')->student_id)->get();

        return view('parents.student_welfare')->with([
            'absent_dates' => $absentDates,
            'discipline_cases' => $disciplineCases,
            'medical_history' => $medicalHistory,
        ]);
    }
}
