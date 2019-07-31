<?php

namespace App\DB\Academics;

use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
