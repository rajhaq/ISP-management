<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    'address', 'image','name', 'number','invoice_message','currency'
    ];
}
