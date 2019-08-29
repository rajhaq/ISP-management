<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'admin_id', 'name', 'code','status'
    ];
    public function admin()
    {
       return $this->belongsTo('App\User', 'admin_id');
    } 
}
