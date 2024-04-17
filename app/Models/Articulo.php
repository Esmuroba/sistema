<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';

    public function scopeNameArticulo ($query, $name){
        if($name)
        return $query->where('nombre_producto','LIKE', "%$name%");
    }

    public function cuentas (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id');
    }

    public function clasificacion (){
        return $this->hasOne(Clasificacion::class, 'nombre', 'clasificacion');
    }

    public function cuentasIva (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id_iva');
    }

    public function cuentasRetIva (){
        return $this->hasOne(Cuenta::class, 'id', 'cuenta_id_ret_iva');
    }

    public function cuentasRetIsr (){
        return $this->hasOne(Cuenta::class, 'id', 'cuenta_id_ret_isr');
    }

    public function cuentasDeprec (){
        return $this->hasOne(Cuenta::class, 'id', 'cuenta_id_deprec');
    }
}
