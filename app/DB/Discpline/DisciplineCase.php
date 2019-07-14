<?php

namespace App\DB\Discpline;

use App\DB\Students\Student;
use Illuminate\Database\Eloquent\Model;

class DisciplineCase extends Model
{
    protected $guarded = [];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
