<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoGasto extends Model
{
    //
    protected $table = 'movimientos_compras';

    public function compra (){
        return $this->hasOne(Gasto::class, 'id', 'compras_id');
    }
    
    public function cuentas (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id');
    }

    public function bancos (){
        return $this->hasOne(Banco::class, 'id', 'cuentas_id');
    }

    public function cajas (){
        return $this->hasOne(Caja::class, 'id', 'cuentas_id');
    }
}
