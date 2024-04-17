<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menus';

    public function submenus (){
        return $this->hasMany(Submenu::class, 'menus_id', 'id')->where('estado_menu','1')->orderBy('nivel','ASC');

    }
}
