<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    //
    protected $table = 'cajas';

    public function responsable (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }

    public function cuenta (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id');
    }

    public function personalsResponsable (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }
}
