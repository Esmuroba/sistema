<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucursalRuta extends Model
{
    //
    protected $table = 'sucursales';

    public function scopeName ($query, $name){
        if($name)
        return $query->where('nombre_ruta','LIKE', "%$name%");
    }

    public function empresa (){
        return $this->hasOne(Empresa::class, 'id', 'empresas_id');
    }

}
