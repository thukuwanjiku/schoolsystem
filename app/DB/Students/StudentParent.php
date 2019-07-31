<?php

namespace App\DB\Students;

use App\ChatMessage;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function sender()
    {
        return $this->morphMany(ChatMessage::class, 'sender');
    }

    public function recipient()
    {
        return $this->morphMany(ChatMessage::class, 'recipient');
    }


    public function addSender(ChatMessage $message)
    {
        return $this->sender()->save($message);
    }
    public function addRecipient(ChatMessage $message)
    {
        return $this->recipient()->save($message);
    }
}
