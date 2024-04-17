<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aval extends Model
{
    //
    protected $table = 'avales';

    public function getFullName (){
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }

    public function cliente (){
        return $this->hasOne(Cliente::class, 'aval_id', 'id');
    }

}
