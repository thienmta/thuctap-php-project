<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'body',
        'url',
        'commentable_id',
        'commentable_type',
        'user_id',
        'progress',
        'status'

    ];

    public function commentable()
    {
        return $this->morphTo();
    }
    

        /**
     * Return the user associated with this comment.
     *
     * @return array
     */
     public function user()
     {
         return $this->hasOne('\App\Model\User', 'id', 'user_id');
     }
}
