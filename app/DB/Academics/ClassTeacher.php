<?php

namespace App\DB\Academics;

use App\DB\Students\StudentGroup;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ClassTeacher extends Model
{
    protected $guarded = [];

    public function studentClass()
    {
        return $this->belongsTo(StudentGroup::class, 'class_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}
