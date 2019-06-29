<?php

namespace App\Http\Controllers\Admin\Students;

use App\DB\Students\Student;
use App\DB\Students\StudentGroup;
use App\DB\Students\StudentParent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentsController extends Controller
{
    public function index()
    {
        //groups
        $groups = StudentGroup::where('is_completed', false)->get();

        //students
        $students = Student::all()->filter(function($student){
            return !$student->group->is_completed;
        });

        return view('admin.students')->with([
            'groups' => $groups,
            'students' => $students
        ]);
    }

    public function add(Request $request)
    {
        //check not student with this admission number
        if(Student::where('admission_no', $request['admission_no'])->first()){
            return back()->withInput($request->all())->withErrors("This admission no is already registered");
        }

        //find the student group
        if(!$group = StudentGroup::find($request['group_id'])){
            return back()->withErrors("Student Group not found");
        }

        //create a student
        $student = Student::create([
            'group_id' => $group->id,
            'name' => $request['student_name'],
            'admission_no' => $request['admission_no']
        ]);

        //create parent
        StudentParent::create([
            'student_id' => $student->id,
            'name' => $request['parent_name'],
            'email' => $request['parent_email'],
            'phone_number' => $request['parent_phone_number']
        ]);

        session()->flash('success', 'Successfully added student');
        return redirect()->route('students');
    }

    public function update(Request $request)
    {
        if(Student::where('admission_no', $request['admission_no'])->where('id', '!=', $request['student_id'])->first()){
            return back()->withInput($request->all())->withErrors("This admission no is already registered");
        }

        if(!$student =  Student::find($request['student_id'])){
            return back()->withInput($request->all())->withErrors("Student not found");
        }

        //update the details
        $student->name = $request['student_name'];
        $student->admission_no = $request['admission_no'];
        $student->parent->name = $request['parent_name'];
        $student->parent->email = $request['parent_email'];
        $student->parent->phone_number = $request['parent_phone_number'];
        $student->parent->save();
        $student->save();

        session()->flash('success', 'Successfully updated student');
        return redirect()->route('students');
    }

    public function delete(Request $request)
    {
        //find the student
        if(!$student = Student::find($request['student_id'])){
            return back()->withErrors("Student not found");
        }

        //delete the student & parent
        $student->parent->delete();
        $student->delete();

        session()->flash('success', 'Successfully deleted Student');
        return redirect()->route('students');
    }
}
