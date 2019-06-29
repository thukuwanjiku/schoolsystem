<?php

namespace App\Http\Controllers\Teacher;

use App\DB\Academics\Exam;
use App\DB\Academics\ExamMark;
use App\DB\Academics\Subject;
use App\DB\Academics\SubjectsAllocation;
use App\DB\Students\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamMarksController extends Controller
{
    public function index()
    {
        $active_exams = Exam::where('is_active', true)->get();
        $allocations = SubjectsAllocation::where('teacher_id', auth()->id())->get();
        $subjects = Subject::all();

        return view('teachers.performance')->with([
            'exams' => $active_exams,
            'allocations' => $allocations,
            'subjects' => $subjects
        ]);
    }

    public function acceptSelections(Request $request)
    {
        $validation = $request->validate([
            'exam_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
        ], [
            'subject_id.required' => "Please select the subject",
            'class_id.required' => "Please select class",
            'exam_id.required' => "Please select the exam",
        ]);

        //get all students in the selected class
        $students = Student::where('group_id', $request['class_id'])->get();
        if(!sizeof($students)){
            return back()->withErrors("There are no students in the selected class");
        }

        $exam = Exam::find($request['exam_id']);
        $subject = Subject::find($request['subject_id']);

        return view('teachers.marks_entry')->with([
            'exam' => $exam,
            'subject' => $subject,
            'students' => $students
        ]);
    }

    public function saveMarks(Request $request)
    {
        $validation = $request->validate([
            'exam_id' => 'required',
            'subject_id' => 'required',
        ], [
            'subject_id.required' => "Please select the subject",
            'exam_id.required' => "Please select the exam",
        ]);

        //loop through all students and record marks
        foreach ($request['student_ids'] as $index => $student_id) {
            if(!empty($request['marks'][$index]) && !empty($request['grades'][$index]) && !empty($request['points'])){
                if(!$examMark = ExamMark::where([
                    'student_id' => $student_id,
                    'exam_id' => $request['exam_id'],
                    'subject_id' => $request['subject_id'],
                ])->first()) {
                    ExamMark::create([
                        'student_id' => $student_id,
                        'exam_id' => $request['exam_id'],
                        'subject_id' => $request['subject_id'],
                        'marks' => $request['marks'][$index],
                        'grade' => $request['grades'][$index],
                        'points' => $request['points'][$index]
                    ]);
                }else{
                    $examMark->marks = $request['marks'][$index];
                    $examMark->grade = $request['grades'][$index];
                    $examMark->points = $request['points'][$index];
                    $examMark->save();
                }
            }
        }

        session()->flash("Successfully saved marks");
        return redirect()->route('exam_marks');
    }
}
