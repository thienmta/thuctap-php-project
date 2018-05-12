<?php
namespace App\Repositories\Tag;

use App\Model\Tag;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: trunghpb
 * Date: 2018/03/05
 * Time: 16:22
 */
class TagEloquentRepository extends BaseRepository
{


    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Tag::class;
    }

    public function getActiveProject() {
        return $this->all();
    }

    /**
     * @param Request $request
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function addTag(Request $request)
    {
        $tag = Tag::create([
            'name' => $request->input('name'),
        ]);
        return $tag;
    }

    public function editTag(Request $request, Tag $tag)
    {
        $tag = Tag::where('id', $tag->id)
            ->update([
                'name' => $request->input('name')
            ]);
        return $tag;
    }

    public function searchTag (Request $request) {
        $tag = Tag::all();
        if ($request->has('nameTag')) {
            $tag = Tag::where('name', 'LIKE', '%' . $request->input('nameTag') . '%')->get();
        }
        return $tag;
    }
}