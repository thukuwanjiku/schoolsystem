<?php

namespace App\Http\Controllers\Admin\Academics;

use App\DB\Academics\SubjectsAllocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectsAllocationController extends Controller
{
    public function allocate(Request $request)
    {
        $validation = $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
        ], [
            'teacher_id.required' => "Please select the teacher",
            'class_id.required' => "Please select the class",
            'subject_id.required' => "Please select the subject",
        ]);

        //check if this allocation exists
        if($allocation = SubjectsAllocation::where([
            'teacher_id' => $request['teacher_id'],
            'class_id' => $request['class_id'],
            'subject_id' => $request['subject_id']
        ])->first()){
            //this allocation exists, send an error message
            return back()->withErrors("This subject allocation already exists");
        }

        SubjectsAllocation::create([
            'teacher_id' => $request['teacher_id'],
            'class_id' => $request['class_id'],
            'subject_id' => $request['subject_id']
        ]);

        session()->flash("success", "Successfully allocated subject");

        return redirect()->route('academics');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'allocation_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
        ], [
            'teacher_id.required' => "Please select the teacher",
            'class_id.required' => "Please select the class",
            'subject_id.required' => "Please select the subject",
        ]);

        //check if this allocation exists
        if($allocation = SubjectsAllocation::where([
            'teacher_id' => $request['teacher_id'],
            'class_id' => $request['class_id'],
            'subject_id' => $request['subject_id']
        ])->where('id', '!=', $request['allocation_id'])->first()){
            //this allocation exists, send an error message
            return back()->withErrors("This subject allocation already exists");
        }

        //find the allocation
        if(!$allocation = SubjectsAllocation::find($request['allocation_id'])){
            return back()->withErrors("Subject allocation not found");
        }

        //update the details
        $allocation->subject_id = $request['subject_id'];
        $allocation->class_id = $request['class_id'];
        $allocation->save();

        session()->flash("success", "Successfully updated allocation");

        return redirect()->route('academics');
    }
}
