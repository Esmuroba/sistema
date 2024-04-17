<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
     //
    protected $table = 'cuentas';
    
    protected $fillable = ['id', 'nombre_cuenta', 'numero_cuenta', 'naturaleza','tipo','nivel','codigo_agrupador','nombre_cuenta_ca'];
}
