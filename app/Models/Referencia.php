<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $table = 'referencias';
    //

    public function getFullName (){
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }
}
