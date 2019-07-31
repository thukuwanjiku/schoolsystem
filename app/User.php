<?php

namespace App;

use App\DB\System\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
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
