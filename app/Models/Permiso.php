<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    //

    protected $table = 'permisos';


    public function submenu (){
        return $this->hasOne(Submenu::class, 'id', 'sub_menus_id');
    }
}
