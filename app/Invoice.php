<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'admin_id', 'customer_id','total_bill','total_amount','status'
    ];
    public function bill()
    {
       return $this->hasMany('App\InvoiceBill')->with('bill');
    } 
    public function admin()
    {
       return $this->belongsTo('App\User','admin_id');
    } 
    public function customer()
    {
       return $this->belongsTo('App\Customer');
    } 
}
