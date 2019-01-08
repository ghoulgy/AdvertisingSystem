<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function markers() {
        return $this->hasMany(Marker::class);
    }

    public function markersdemand() {
        return $this->hasMany(MarkerDemand::class);
    }

    public function sentRequests() {
        return $this->hasMany(UserRequest::class, 'from_user_id');
    }

    public function receivedRequests() {
        return $this->hasMany(UserRequest::class, 'to_user_id');
    }
}
