<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacciones extends Model
{
    //
    protected $table = 'transacciones';

    public function amortizacion (){
        return $this->hasOne(TablaAmortizacion::class, 'id', 'tabla_amortizacion_id');
    }

    public function bancos (){
        return $this->hasOne(Banco::class, 'id', 'cuentas_id');
    }
}
