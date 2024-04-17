<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{

    protected $table = 'branch_offices';

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(name) LIKE '%$name%' ");
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
