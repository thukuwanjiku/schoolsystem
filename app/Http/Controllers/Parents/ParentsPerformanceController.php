<?php

namespace App\Http\Controllers\Parents;

use App\DB\Academics\Exam;
use App\DB\Academics\ExamMark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParentsPerformanceController extends Controller
{
    public function index(Request $request)
    {
        //fetch inactive exams
        $exams = Exam::where('is_active', false)->get();
        $data = null;
        $examMarks = null;

        if(!empty($request['exam_id'])){
            //get the student marks for the selected exam
            $examMarks = ExamMark::where([
                'student_id' => session()->get('parent_auth')->student_id,
                'exam_id' => $request['exam_id']
            ])->get();

            //calculate total marks
            $totalMarks = $examMarks->sum(function($mark){
                return (float)$mark->marks;
            });
            $totalPoints = $examMarks->sum(function($mark){
                return (float)$mark->points;
            });
            $avgPoints = $totalPoints / $examMarks->count();

            //get mean grade
            $meanGrade = '';
            switch (true){
                case $avgPoints >= 11.5:
                    $meanGrade = 'A';
                    break;

                case $avgPoints >= 10.5 && $avgPoints <= 11.4:
                    $meanGrade = 'A-';
                    break;

                case $avgPoints >= 9.5 && $avgPoints <= 10.4:
                    $meanGrade = 'B+';
                    break;

                case $avgPoints >= 8.5 && $avgPoints <= 9.4:
                    $meanGrade = 'B';
                    break;

                case $avgPoints >= 7.5 && $avgPoints <= 8.4:
                    $meanGrade = 'B-';
                    break;

                case $avgPoints >= 6.5 && $avgPoints <= 7.4:
                    $meanGrade = 'C+';
                    break;

                case $avgPoints >= 5.5 && $avgPoints <= 6.4:
                    $meanGrade = 'C';
                    break;

                case $avgPoints >= 4.5 && $avgPoints <= 5.4:
                    $meanGrade = 'C-';
                    break;

                case $avgPoints >= 3.5 && $avgPoints <= 4.4:
                    $meanGrade = 'D+';
                    break;

                case $avgPoints >= 2.5 && $avgPoints <= 3.4:
                    $meanGrade = 'D';
                    break;

                case $avgPoints >= 1.5 && $avgPoints <= 2.4:
                    $meanGrade = 'D-';
                    break;

                case $avgPoints <= 1.4:
                    $meanGrade = 'E';
                    break;
            }

            $data['avg_points'] = $avgPoints;
            $data['mean_grade'] = $meanGrade;
            $data['student_name'] = session()->get('parent_auth')->student->name;
            $data['exam_name'] = Exam::find($request['exam_id'])->label;
        }

        return view('parents.performance')->with([
           'exams'  => $exams,
            'data' => $data,
            'subject_marks' => $examMarks
        ]);
    }
}
