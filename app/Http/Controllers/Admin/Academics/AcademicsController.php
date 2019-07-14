<?php

namespace App\Http\Controllers\Admin\Academics;

use App\DB\Academics\ClassTeacher;
use App\DB\Academics\Exam;
use App\DB\Academics\Subject;
use App\DB\Academics\SubjectsAllocation;
use App\DB\Students\StudentGroup;
use App\DB\System\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcademicsController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $exams = Exam::latest()->get();
        //fetch all teachers
        $teacherRole = Role::where('label', 'teacher')->first();
        $teachers = User::where('role_id', $teacherRole->id)->get();
        $classes = StudentGroup::where('is_completed', false)->get();
        $subject_allocations = SubjectsAllocation::all();
        $class_teachers = ClassTeacher::all()->filter(function($classTeacher){ return !$classTeacher->studentClass->is_completed; });

        return view('admin.academics')->with([
            'subjects' => $subjects,
            'exams' => $exams,
            'teachers' => $teachers,
            'classes' => $classes,
            'subject_allocations' => $subject_allocations,
            'class_teachers' => $class_teachers,
        ]);
    }
}
