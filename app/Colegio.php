<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Colegio extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at', 'pivot'
    ];
}
