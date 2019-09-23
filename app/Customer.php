<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'admin_id', 'email', 'name','contact', 'address', 'area_id','package_id',
        'cnic', 'status'
    ];
    public function admin()
    {
       return $this->belongsTo('App\User', 'admin_id');
    } 
    public function package()
    {
       return $this->belongsTo('App\Package', 'package_id');
    } 
    public function area()
    {
       return $this->belongsTo('App\Area', 'area_id');
    } 
}
