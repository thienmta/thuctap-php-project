<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //

    protected $fillable = [
        'id',
        'name',
        'description',
        'user_id'

    ];

    public function user(){
		return $this->belongsTo('App\Model\User');
    }

    public function projects(){
        return $this->hasMany('App\Model\Project');
    }

    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }
}
