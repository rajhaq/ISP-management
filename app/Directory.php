<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    protected $fillable = [
        'admin_id', 'name', 'position','account_permission', 'gender', 'nickname','routine'
        ,'notes','call_eligible','emergency','oncall','general','message_handling','status'
    ];
    public function contact()
    {
       return $this->hasMany('App\DirectoryContact');
    }
}
