<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $table = 'jobs';

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(name) LIKE '%$name%' ");
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function area (){
        return $this->hasOne(Area::class, 'id', 'area_id');
    }
}
