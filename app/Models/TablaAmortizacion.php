<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablaAmortizacion extends Model
{
    protected $table = 'tabla_amortizacion';
    protected $guarded = [];
    //

    public function movimiento (){
        return $this->hasOne(MovimientoGasto::class, 'tabla_amortizacion_id', 'id');
    }

    public function analisisC (){
        return $this->hasOne(Analisis_credito::class, 'id', 'analisis_credito_id');
    }

    public function cobro (){
        return $this->hasOne(MovimientoGasto::class, 'tabla_amortizacion_id', 'id');
    }

    public function cobroTransaccion (){
        return $this->hasOne(Transacciones::class, 'tabla_amortizacion_id', 'id');
    }

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
}
