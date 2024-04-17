<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{

    protected $table = 'catalogs';

    protected $fillable = [
        'name',
        'description',
        'code',
        'status',
        'is_currently'
    ];

    // Relaciones
    public function catItems()
    {
        return $this->hasMany(CatItems::class);
    }

}
