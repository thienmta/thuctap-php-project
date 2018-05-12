<?php
namespace App\Repositories\Project;
use App\Model\Project;
use App\Model\ProjectStaff;
use App\Model\ProjectTag;
use App\Repositories\Tag\TagEloquentRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: trunghpb
 * Date: 2018/03/05
 * Time: 16:22
 */
class ProjectEloquentRepository extends BaseRepository
{
    /** @var  Builder */
    private $findBuider;

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Project::class;
    }

    public function getActiveProject() {
        return $this->all();
    }

    /**
     * @param Request $request
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function addProject(Request $request)
    {
        $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'company_id' => $request->input('company_id'),
            'start_at' => $request->input('start_at'),
            'finish_at' => $request->input('finish_at'),
            'completed' => $request->input('completed'),
            'user_id' => Auth::user()->id
        ]);
        return $project;
    }


    /**
     * @param Request $request
     * @param Project $project
     *
     * @return bool
     */
    public function update(Request $request, Project $project)
    {
        $projectUpdate = Project::where('id', $project->id)
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'start_at' => $request->input('start_at'),
                'finish_at' => $request->input('finish_at'),
                'completed' => $request->input('completed'),
            ]);
        return $projectUpdate;
    }

    /**
     * @param $request
     *
     * @return bool
     */
    private function isConsiderActiveProject(Request $request) {
        return $request->has('is_active') || $request->input('is_active') == 1;
    }

    /**
     * @param $request
     *
     * @return $this
     */
    public function withNotFinishedProject(Request $request)
    {
        if ($this->isConsiderActiveProject($request)) {
            $this->findBuider->where('finish_at', '>=', date('Y-m-d'));
        }
        return $this;
    }

    /**
     * @param $request
     *
     * @return bool
     */
    private function hasStartBegin(Request $request){
        return $request->has('start_at_begin');
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function hasStartEnd(Request $request){
        return $request->has('start_at_end');
    }

    /**
     * @param Request $request
     *
     * @return $this
     */

    private function hasInputNameProject(Request $request){
        return $request->has('nameProject') && trim($request->get('nameProject')) != null;
    }

    private function hasInputNameTag(Request $request){
        return $request->has('nameTag') && trim($request->get('nameTag')) != null;
    }

    public function withFinishAt(Request $request){
        if (($request->input('finish_from')) != '') {
            $this->findBuider->where('finish_at', '>=', $request->input('finish_from'));
        }
        if (($request->input('finish_to')) != '') {
            $this->findBuider->where('finish_at', '<=', $request->input('finish_to'));
        }
        return $this;
    }

    public function withInputNameProject(Request $request){
        if ($this->hasInputNameProject($request)) {
            $this->findBuider->where('name', 'LIKE', '%' . $request->input('nameProject') . '%');
        }
        return $this;
    }

    public function withStartExist(Request $request){
        if (($request->input('start_at_begin')) != '') {
            $this->findBuider->where('start_at', '>=', $request->input('start_at_begin'));
        }
        if (($request->input('start_at_end')) != '') {
            $this->findBuider->where('start_at', '<=', $request->input('start_at_end'));
        }
        return $this;
    }

    public function withNameTag (Request $request) {
        if ($this->hasInputNameTag($request)) {
            $tag = new TagEloquentRepository();
            $tagId = [];
            foreach ($tag->searchTag($request) as $key => $id) {
                $tagId[] = $id->id;
            }
            $projectTag = ProjectTag::whereIn('tag_id', $tagId)->pluck('project_id')->toArray();
            $this->findBuider->whereIn('id', $projectTag);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function withFirstComment(){
        $this->findBuider = Project::with(['comments' => function ($q) {
            $q->orderBy('id', 'DESC');
        }]);

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     * @internal param $filter
     *
     */

    public function findName(Request $request) {
        $this->withFirstComment()
            ->withNotFinishedProject($request)
            ->withInputNameProject($request);
        return $this;
    }

    public function find(Request $request)
    {
        $this->findName($request)
            ->withFinishAt($request)
            ->withStartExist($request)
            ->withNameTag($request);
        return $this->findBuider->paginate(1);
    }

    /**
     * @param Request $request
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function addStaffToProject(Request $request)
    {
        $projectStaff = ProjectStaff::create([
            'staff_id' => $request->input('staff_id'),
            'project_id' => $request->input('project_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'participation_rates' => $request->input('participation_rates'),
            'user_id' => Auth::user()->id
        ]);
        return $projectStaff;
    }

    public function addTagToProject(Request $request)
    {
        $projectTag = '';
        foreach ($request->get('tags') as $tag) {
            $projectTag = ProjectTag::create([
                'tag_id' => $tag,
                'project_id' => $request->get('project_id')
            ]);
        }
        return $projectTag;
    }

    public function deleteProject ($id) {
        try {
            DB::transaction(function () use($id){
                DB::table('project_tag')->where('project_id', $id)->delete();
                DB::table('project_staff')->where('project_id', $id)->delete();
                DB::table('projects')->where('id', $id)->delete();
            });
        }
        catch (Exception $exception) {
            return redirect()->back()->with('errors', 'Project deleted errors');
        }
    }
}