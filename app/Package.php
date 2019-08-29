<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'admin_id', 'name', 'code','price','status'
    ];
}
