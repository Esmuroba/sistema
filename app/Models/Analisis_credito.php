<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analisis_credito extends Model
{
    protected $table = 'analisis_credito';

    public function solicitud (){
        return $this->hasOne(Solicitud::class, 'id', 'solicituds_id');
    }

    public function tablaAmortizacion (){
        return $this->hasOne(tablaAmortizacion::class, 'analisis_credito_id', 'id');
    }

    public function detalleDesembolso (){
        return $this->hasOne(MovimientoGasto::class, 'analisis_credito_id', 'id');
    }
    
    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
}
