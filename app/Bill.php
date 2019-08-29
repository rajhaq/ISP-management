<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'admin_id', 'customer_id', 'package','price', 
        'status'
    ];
    public function admin()
    {
       return $this->belongsTo('App\User', 'admin_id');
    } 
    public function customer()
    {
       return $this->belongsTo('App\Customer', 'customer_id');
    } 

}
