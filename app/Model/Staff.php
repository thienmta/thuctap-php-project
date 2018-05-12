<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    protected $fillable = [
        'id',
        'full_name',
        'nick_name',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function projects(){
        return $this->belongsToMany('App\Model\Project');
    }

    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }
}
