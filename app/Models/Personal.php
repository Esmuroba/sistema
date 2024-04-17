<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{

    protected $table = 'personals';

   
    // Relaciones
    public function user()
    {
        return $this->hasOne(User::class);
    }


    // Para obtener el nombre completo
    public function getFullName()
    {
        return $this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }

    public function getName (){
        return "{$this->nombre} {$this->apellido_paterno}";
    }

    // public function branch(){
    //     return $this->hasOne(BranchOffice::class, 'id', 'branch_office_id');
    // }

  

    // public function job (){
    //     return $this->hasOne(Job::class, 'id', 'job_id');
    // }

    public function scopeName ($query, $name){
        if($name)
        // return $query->where('nombre','LIKE', "%$name%");
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
}
