<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'user_id', 'shop_name', 'shop_contact','shop_instagram', 'shop_facebook', 'shop_snapchat','shop_address'
        ,'shop_map','shop_location','shop_type','status'
    ];
}
