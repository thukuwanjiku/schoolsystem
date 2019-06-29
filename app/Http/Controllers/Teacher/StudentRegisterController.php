<?php

namespace App\Http\Controllers\Teacher;

use App\DB\Students\Student;
use App\DB\Students\StudentGroup;
use App\DB\Students\StudentsRegister;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentRegisterController extends Controller
{
    public function index()
    {
        $classes = StudentGroup::where('is_completed', false)->get();

        return view('teachers.search_register')->with([
            'classes' => $classes,
        ]);
    }

    public function searchRegister(Request $request)
    {
        $validation = $request->validate([
            'class_id' => 'required',
            'register_date' => 'required',
        ], [
            'class_id.required' => "Please select the class",
            'register_date.required' => "Please select the date",
        ]);


        $students = Student::where('group_id', $request['class_id'])->get();
        $register = StudentsRegister::where([
            'class_id' => $request['class_id'],
            'created_at' => Carbon::parse($request['register_date'])
        ])->get();

        $students_register = $students->map(function($student)use($register){
           $studentArray= [
               'student_name' => $student->name,
               'is_present' => false
           ];

           if(
               $registerEntry = $register->where('student_id', $student->id)->first()
           ){
               $studentArray['is_present'] = (bool)$registerEntry->is_present;
           }

           return $studentArray;
        });

        return view('teachers.register')->with([
            'students' => $students_register,
            'current_class' => StudentGroup::find($request['class_id']),
            'register_date' => Carbon::parse($request['register_date'])->toFormattedDateString(),
        ]);
    }
}
