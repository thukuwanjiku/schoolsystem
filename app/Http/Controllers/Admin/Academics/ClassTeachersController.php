<?php

namespace App\Http\Controllers\Admin\Academics;

use App\DB\Academics\ClassTeacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassTeachersController extends Controller
{
    public function assign(Request $request)
    {
        $validation = $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
        ], [
            'teacher_id.required' => "Please select the teacher",
            'class_id.required' => "Please select the class",
        ]);

        //check if this teacher is already assigned another class
        if($exists = ClassTeacher::where('teacher_id', $request['teacher_id'])->first()){
            return back()->withErrors("This teacher is already class teacher at ".$exists->studentClass->name);
        }

        //check if this class already has a class teacher
        if($exists = ClassTeacher::where('class_id', $request['class_id'])->first()){
            return back()->withErrors("This class already has a class teacher:  ".$exists->teacher->name);
        }

        //assigne the class teacher
        ClassTeacher::create([
            'class_id' => $request['class_id'],
            'teacher_id' => $request['teacher_id']
        ]);

        session()->flash("success", "Successfully assigned Class Teacher");
        return redirect()->route('academics');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'record_id' => 'required',
            'teacher_id' => 'required',
            'class_id' => 'required',
        ], [
            'teacher_id.required' => "Please select the teacher",
            'class_id.required' => "Please select the class",
        ]);

        //check if this teacher is already assigned another class
        if($exists = ClassTeacher::where('teacher_id', $request['teacher_id'])->where('class_id', "!=", $request['class_id'])->first()){
            return back()->withErrors("This teacher is already class teacher at ".$exists->studentClass->name);
        }

        //find the class teacher record
        if(!$classTeacher = ClassTeacher::find($request['record_id'])){
            return back()->withErrors("Record not found");
        }

        //update the class teacher
        $classTeacher->teacher_id = $request['teacher_id'];
        $classTeacher->save();

        session()->flash("success", "Successfully updated record");
        return redirect()->route('academics');
    }

    public function delete(Request $request)
    {
        $validation = $request->validate([
            'record_id' => 'required',
        ]);

        //find the class teacher record
        if(!$classTeacher = ClassTeacher::find($request['record_id'])){
            return back()->withErrors("Record not found");
        }

        //update the class teacher
        $classTeacher->delete();

        session()->flash("success", "Successfully deleted record");
        return redirect()->route('academics');
    }
}
