<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectoryContact extends Model
{
    protected $fillable = [
        'admin_id', 'directory_id', 'contact','contact_type'
    ];
    public function directory()
    {
       return $this->belongsTo('App\Directory');
    }
}
