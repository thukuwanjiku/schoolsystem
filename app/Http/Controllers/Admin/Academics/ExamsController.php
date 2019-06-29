<?php

namespace App\Http\Controllers\Admin\Academics;

use App\DB\Academics\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ExamsController extends Controller
{
    public function add(Request $request)
    {
        $validation = $request->validate([
            'exam_name' => [
                'required',
                Rule::unique('exams', 'label')->ignore($request['exam_id'])
            ],
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'exam_name.required' => "Please enter the exam name",
            'exam_name.unique' => "This exam already added",
            'start_date.required' => "Please select the exam start date",
            'end_date.required' => "Please select the exam end date",
        ]);

        Exam::create([
            'label' => $request['exam_name'],
            'start_date' => Carbon::parse($request['start_date']),
            'end_date' => Carbon::parse($request['end_date']),
            'is_active' => false
        ]);

        session()->flash("success", "Successfully added exam");

        return redirect()->route('academics');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'exam_id' => "required",
            'exam_name' => [
                'required',
                Rule::unique('exams', 'label')
            ],
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'exam_name.required' => "Please enter the exam name",
            'exam_name.unique' => "This exam already added",
            'start_date.required' => "Please select the exam start date",
            'end_date.required' => "Please select the exam end date",
        ]);

        //find the exam
        if(!$exam = Exam::find($request['exam_id'])){
            return back()->withErrors("Exam not found");
        }

        //update the details
        $exam->label = $request['exam_name'];
        $exam->start_date = $request['start_date'];
        $exam->end_date = $request['end_date'];
        $exam->save();

        session()->flash("success", "Successfully updated exam");

        return redirect()->route('academics');
    }

    public function changeStatus(Request $request)
    {
        $validation = $request->validate([
            'exam_id' => "required",
        ]);

        //find the exam
        if(!$exam = Exam::find($request['exam_id'])){
            return back()->withErrors("Exam not found");
        }

        //update the details
        $exam->is_active = !$exam->is_active;
        $exam->save();

        session()->flash("success", "Successfully updated");

        return redirect()->route('academics');
    }
}
