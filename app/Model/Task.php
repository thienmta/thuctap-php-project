<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'name',
        'project_id',
        'user_id',
        'days',
        'hours',
        'company_id'
    ];


    public function user(){
		return $this->belongsTo('App\Model\User');
    }

    public function project(){
		return $this->belongsTo('App\Model\Project');
    }

    public function company(){
		return $this->belongsTo('App\Model\Company');
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }

    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }
}

