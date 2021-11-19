<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at', 'pivot'
    ];

    public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'carrera_sedes', 'carrera_id', 'sede_id');
    }
}
