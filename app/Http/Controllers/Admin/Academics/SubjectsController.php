<?php

namespace App\Http\Controllers\Admin\Academics;

use App\DB\Academics\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class SubjectsController extends Controller
{
    public function add(Request $request)
    {
        $validation = $request->validate([
            'subject_name' => [
                'required',
                Rule::unique('subjects', 'label')
            ],
        ], [
            'subject_name.required' => "Please enter the subject name",
            'subject_name.unique' => "This subject is already added",
        ]);

        Subject::create([
            'label' => $request['subject_name']
        ]);

        session()->flash("success", "Successfully added subject");

        return redirect()->route('academics');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'subject_id' => 'required',
            'subject_name' => [
                'required',
                Rule::unique('subjects', 'label')->ignore($request['subject_id'])
            ],
        ], [
            'subject_name.required' => "Please enter the subject name",
            'subject_name.unique' => "This subject is already added",
        ]);

        //find the subject
        if(!$subject = Subject::find($request['subject_id'])){
            return back()->withErrors("Subject not found");
        }

        //update the subject
        $subject->label = $request['subject_name'];
        $subject->save();

        session()->flash("success", "Successfully updated subject");

        return redirect()->route('academics');
    }

    public function delete(Request $request)
    {
        $validation = $request->validate([
            'subject_id' => 'required',
        ]);

        //find the subject
        if(!$subject = Subject::find($request['subject_id'])){
            return back()->withErrors("Subject not found");
        }

        //delete the subject
        $subject->delete();

        session()->flash("success", "Successfully deleted subject");

        return redirect()->route('academics');
    }
}
