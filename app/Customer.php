<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    $table->integer('admin_id');
    $table->string('customer_email')->nullable();
    $table->string('customer_name');
    $table->string('customer_contact')->nullable();;
    $table->string('customer_instagram')->nullable();;
    $table->string('customer_facebook')->nullable();;
    $table->string('customer_snapchat')->nullable();;
    $table->text('customer_address');
    $table->string('customer_type')->default('regular');
    $table->boolean('customer_map')->default(false);
    $table->string('customer_location')->nullable();
    $table->integer('status')->default(1);
    protected $fillable = [
        'user_id', 'shop_name', 'shop_contact','shop_instagram', 'shop_facebook', 'shop_snapchat','shop_address'
        ,'shop_map','shop_location','shop_type','status'
    ];
}
