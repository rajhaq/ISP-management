<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceBill extends Model
{

    protected $fillable = [
         'invoice_id', 'bill_id'
    ];
    public function bill()
    {
       return $this->belongsTo('App\Bill')->with('package_data');
    } 

}