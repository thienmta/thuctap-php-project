<?php

namespace App\Validators;

class CommentValidator
{
    public function registerAddComment()
    {
        return [
            'body' => 'required',
            'url' => '',
            'commentable_type' => 'required',
            'commentable_id' => 'required',
            'status' => 'required|numeric',
            'progress' => 'required|numeric',
        ];
    }
}