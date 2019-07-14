<?php

namespace App\Http\Controllers\Discipline;

use App\DB\Discpline\DisciplineCase;
use App\DB\Students\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisciplineController extends Controller
{
    public function index()
    {
        $reports = DisciplineCase::where('disciplinarian', auth()->id())->get();

        return view('discipline.discipline_cases')->with([
            'reports' => $reports
        ]);
    }

    public function newIndisciplineCase()
    {
        return view('discipline.new_indiscipline_case');
    }

    public function saveDisciplineCase(Request $request)
    {
        //validate request
        $validation = $request->validate([
            'student_admission' => 'required',
            'offense_desc' => 'required',
            'punishment' => 'required',
        ], [
            'student_admission.required' => "Please enter the student admission number",
            'offense_desc.required' => "Please enter the offenses description",
            'punishment_id.required' => "Please enter the punishment",
        ]);

        //get the student using the admission
        if(!$student = Student::where('admission_no', $request['student_admission'])->first()){
            return back()->withInput()->withErrors("No student with that Admission No.");
        }

        //create new discipline case
        DisciplineCase::create([
            'student_id' => $student->id,
            'disciplinarian' => auth()->id(),
            'offense' => $request['offense_desc'],
            'punishment' => $request['punishment'],
        ]);

        session()->flash('success', 'Successfully reported discipline case');
        return redirect()->route('discipline');
    }
}
