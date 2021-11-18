<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    
    public function comunas()
    {
        return $this->hasMany('App\Comuna', 'region_id');
    }

    public function sedes()
    {
        return $this->hasMany('App\Sede', 'region_id');
    }
}
