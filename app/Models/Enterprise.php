<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    
    protected $table = 'enterprises';

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(name) LIKE '%$name%' ");
    }

    // Relaciones
    public function configs()
    {
        return $this->hasOne(EnterpriseConfig::class);
    }

    public function collaboratorInCharge()
    {
        return $this->belongsTo(Collaborator::class, 'manager_id', 'id')->withDefault();
    }

    public function branchOffices()
    {
        return $this->hasMany(BranchOffice::class);
    }
    
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function paymentScheme()
    {
        return $this->belongsTo(CatItems::class, 'payment_scheme_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(EnterprisePayment::class);
    }
}
