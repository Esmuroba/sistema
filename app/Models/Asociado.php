<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asociado extends Model
{
    protected $table = 'asociados';

    public function getFullName (){
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }
    
    public function operadores (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }

    public function namePuesto (){
        return $this->hasOne(Puesto::class, 'id', 'puesto');
    }

    public function ruta (){
        return $this->hasOne(SucursalRuta::class, 'id', 'sucursales_id');
    }

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
}
