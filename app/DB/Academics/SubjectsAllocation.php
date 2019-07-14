<?php

namespace App\DB\Academics;

use App\DB\Students\StudentGroup;
use App\DB\System\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SubjectsAllocation extends Model
{
    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    public function student_class()
    {
        return $this->belongsTo(StudentGroup::class, 'class_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
