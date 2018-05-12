<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'company_id',
        'user_id',
        'days',
        'start_at',
        'finish_at',
        'completed',
    ];


    public function users(){
		return $this->belongsToMany('App\Model\User');
    }

    public function project_staff()
    {
        return $this->hasMany('App\Model\ProjectStaff');
    }

    public function staff()
    {
        return $this->belongsToMany('App\Model\Staff');
    }

    public function company(){
		return $this->belongsTo('App\Model\Company');
    }

    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }

    public function project_tag()
    {
        return $this->hasMany('App\Model\ProjectTag');
    }

}
