<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use App\Repositories\Tag\TagEloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    const IS_ACTIVE = 0;
    const IS_DELETED = 1;
    private $staff;

    public function __construct(TagEloquentRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()) {
            $tags = Tag::where('is_deleted', self::IS_ACTIVE)->paginate(10);
            return view('tags.index', ['tags' => $tags]);
        }
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('tags.create');
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
            if ($this->is_exist($request->input('name'))) {
                return redirect()->route('tag.create')->withErrors(['Tag name existed']);
            }

            $tag = $this->tag->addTag($request);
            if ($tag) {
                return redirect()->route('tag.show', ['tag' => $tag->id])
                    ->with('success', 'Tag created successfully');
            }

        }

        return back()->withInput()->with('errors', 'Error creating new staff');

    }

    private function is_exist($name)
    {
        $tag = Tag::where('name', $name)->get()->toArray();
        return (empty($tag)) ? false : true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $tag = Tag::find($tag->id);

        return view('tags.show', ['tag' => $tag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
        $tag = Tag::find($tag->id);

        return view('tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {

        //save data
        $tagUpdate = $this->tag->editTag($request, $tag);

        if ($tagUpdate) {
            return redirect()->route('tag.show', ['tag' => $tag->id])
                ->with('success', 'Tag updated successfully');
        }
        //redirect
        return back()->withInput();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //

        $findTag = Tag::find($tag->id);
        if ($findTag->delete()) {

            //redirect
            return redirect()->route('tag.index')
                ->with('success', 'Tag deleted successfully');
        }

        return back()->withInput()->with('error', 'Tag could not be deleted');


    }
}
