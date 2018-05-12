<?php

namespace App\Repositories\Comment;


use App\Model\Comment;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentEloquentRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Comment::class;
    }

    public function getActiveProject()
    {
        return $this->all();
    }

    public function addComment(Request $request)
    {
        $status = $request->input('status');
        $progress = $request->input('progress');
        $comment = Comment::create([
            'body' => $request->input('body'),
            'url' => $request->input('url'),
            'commentable_type' => $request->input('commentable_type'),
            'commentable_id' => $request->input('commentable_id'),
            'user_id' => Auth::user()->id,
            'status' => $status,
            'progress' => $progress,
        ]);

        return $comment;
    }
}