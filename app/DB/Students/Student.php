<?php

namespace App\DB\Students;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(StudentParent::class, 'student_id', 'id');
    }
}
