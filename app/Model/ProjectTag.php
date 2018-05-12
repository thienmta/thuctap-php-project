<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model
{
    protected $table = "project_tag";

    protected $fillable = [
        'id',
        'tag_id',
        'project_id',
        'created_at',
        'updated_at'
    ];

    public function tags()
    {
        return $this->hasOne('App\Model\Tag', 'id', 'tag_id');
        // 1 ProjectTag co 1 Tag -- khoa chinh, khoa ngoai trong table project_tag
    }

    public function projects()
    {
        return $this->hasOne('App\Model\Project');
    }
}
