<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    
    public function region()
    {
        return $this->belongsTo('App\Region', 'region_id');
    }

    public function ensayos()
    {
        return $this->hasMany('App\Ensayo', 'sede_id');
    }
}
