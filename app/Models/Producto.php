<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table = 'productos';

    public function cuentas (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id');
    }

    public function scopeName ($query, $name){
        if($name)
        return $query->where('nombre','LIKE', "%$name%");
    }
}
