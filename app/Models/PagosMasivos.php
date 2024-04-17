<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagosMasivos extends Model
{
    //
    protected $table = 'pagos_masivos';

    protected $fillable = [
        'solicituds_id',
        'analisis_credito_id',
        'fecha_pago',
        'tipo_pago',
        'monto_pago',
        'cuentas_id',
        'referencia',
        'observaciones',
        // Otros atributos que puedas tener en tu modelo
    ];

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }

    public function analisis (){
        return $this->hasOne(Analisis_credito::class, 'id', 'analisis_credito_id');
    }

    public function solicitud (){
        return $this->hasOne(Solicitud::class, 'id', 'solicituds_id');
    }
}
