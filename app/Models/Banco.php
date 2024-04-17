<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    //
    protected $table = 'bancos';

    public function personalsFirmante (){
        return $this->hasOne(Personal::class, 'id', 'personals_id_firmante');
    }

    public function personalsResponsable (){
        return $this->hasOne(Personal::class, 'id', 'personals_id_responsable');
    }

    public function cuenta (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id');
    }

}
