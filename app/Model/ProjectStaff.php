<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectStaff extends Model
{
    protected $table = "project_staff";

    protected $fillable = [
        'staff_id',
        'project_id',
        'user_id',
        'start_date',
        'end_date',
        'participation_rates'
    ];

    public function staff()
    {
        return $this->hasOne('App\Model\Staff');
    }

    public function projects()
    {
        return $this->hasOne('App\Model\Project');
    }
}
