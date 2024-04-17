<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

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

   
    public function personal (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }

    public function rol (){
        return $this->hasOne(Rol::class, 'id', 'roles_id');
    }

    public function permisos (){
        return $this->hasMany(Permiso::class, 'roles_id', 'roles_id');
    }
}
