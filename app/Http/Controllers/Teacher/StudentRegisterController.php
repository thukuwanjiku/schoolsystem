<?php

namespace App\Http\Controllers\Teacher;

use App\DB\Academics\ClassTeacher;
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

        //check where there teacher logged in is a class teacher
        $isClassTeacher = false;
        if($classTeacher = ClassTeacher::where('teacher_id', auth()->id())->first()){
            $isClassTeacher = !$classTeacher->studentClass->is_completed;
        }

        return view('teachers.search_register')->with([
            'classes' => $classes,
            'isClassTeacher' => $isClassTeacher
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
            'register_date' => Carbon::parse($request['register_date'])->toDateString()
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

    public function registerToday()
    {
        $class_id = ClassTeacher::where('teacher_id', auth()->id())->first()->class_id;
        $students = Student::where('group_id', $class_id)->get();
        $register = StudentsRegister::where([
            'class_id' => $class_id,
            'register_date' => Carbon::now()->toDateString(),
        ])->get();

        $students_register = $students->map(function($student)use($register){
            $studentArray= [
                'student_name' => $student->name,
                'student_id' => $student->id,
                'is_present' => false
            ];

            if(
                $registerEntry = $register->where('student_id', $student->id)->first()
            ){
                $studentArray['is_present'] = (bool)$registerEntry->is_present;
            }

            return $studentArray;
        });

        return view('teachers.class_register')->with([
            'students' => $students_register,
            'current_class' => StudentGroup::find($class_id),
        ]);
    }

    public function updateRegisterToday(Request $request)
    {
        $validation = $request->validate([
            'class_id' => 'required',
        ]);


        foreach ($request['student_ids'] as $student_id) {
            $is_present = false;
            if(isset($request['student_'.$student_id]) && $request['student_'.$student_id] == 'on'){
                $is_present = true;
            }

            if(!$studentRegisterEntry = StudentsRegister::where([
                'class_id' => $request['class_id'],
                'student_id' => $student_id,
                'register_date' => Carbon::now()->toDateString(),
            ])->first()){
                StudentsRegister::create([
                    'class_id' => $request['class_id'],
                    'student_id' => $student_id,
                    'register_date' => Carbon::now()->toDateString(),
                    'is_present' => $is_present,
                ]);
            }else{
                $studentRegisterEntry->is_present = $is_present;
                $studentRegisterEntry->save();
            }
        }

        session()->flash("Successfully update class register");
        return redirect()->route('register');
    }
}
