<?php

namespace App\DB\Medical;

use App\DB\Students\Student;
use App\User;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id', 'id');
    }
}
