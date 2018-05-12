<?php

namespace App\Http\Controllers;

use App\Model\Comment;
use App\Repositories\Comment\CommentEloquentRepository;
use Illuminate\Http\Request;
use App\Validators\CommentValidator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @property CommentEloquentRepository comment
 */
class CommentsController extends Controller
{
    private $comment;
    private $commentValidator;

    public function __construct(CommentEloquentRepository $comment, CommentValidator $commentValidator)
    {
        $this->comment = $comment;
        $this->commentValidator = $commentValidator;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $rules = $this->commentValidator->registerAddComment();
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator->messages());
            }
            $comment = $this->comment->addComment($request);
            if ($comment) {
                return back()->with('success', 'Comment created successfully');
            }
        }

        return back()->withInput()->with('errors', 'Error creating new comment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
