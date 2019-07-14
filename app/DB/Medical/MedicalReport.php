<?php

namespace App\DB\Medical;

use App\DB\Students\Student;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
