<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $guarded = [];

    public function sender()
    {
        return $this->morphTo();
    }

    public function recipient()
    {
        return $this->morphTo();
    }


    public function getMsgClass()
    {
        if(auth()->check()){
            if($this->sender_type === 'user'){
                return "message-main-sender";
            }

            return "message-main-receiver";
        }else{
            if($this->sender_type === 'user'){
                return "message-main-receiver";
            }

            return "message-main-sender";
        }

    }
    public function getContainerClass()
    {
        if(auth()->check()){
            if($this->sender_type === 'user'){
                return "sender";
            }

            return "receiver";
        }else{
            if($this->sender_type === 'user'){
                return "receiver";
            }

            return "sender";
        }

    }
    public function messageArray()
    {
        return [
            'message' => $this->message,
            'chat_id' => $this->chat_id,
            'time' => Carbon::parse($this->created_at)->toDateTimeString(),
            'msg_class' => $this->getMsgClass(),
            'container_class' => $this->getContainerClass(),
        ];
    }
}
