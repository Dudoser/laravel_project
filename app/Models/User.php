<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'phone_number',
    ];

    public function userToken()
    {
        return $this->hasOne(UserToken::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }


}
