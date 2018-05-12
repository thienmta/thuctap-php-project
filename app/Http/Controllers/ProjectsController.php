<?php

namespace App\Http\Controllers;

use App\Model\Project;
use App\Model\Company;
use App\Model\Staff;
use App\Model\ProjectUser;
use App\Model\ProjectStaff;
use App\Model\ProjectTag;
use App\Model\User;
use App\Model\Tag;
use App\Validators\AddTagToProjectValidator;
use App\Repositories\Project\ProjectEloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    const IS_ACTIVE = 0;
    const IS_DELETED = 1;
    /**
     * @var ProjectEloquentRepository
     */
    private $project;
    private $validator;

    public function __construct(ProjectEloquentRepository $project, AddTagToProjectValidator $validator)
    {
        $this->project = $project;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {

            $projects = $this->project->find($request);
            return view('projects.index', [
                'projects' => $projects,
                'start_at_begin' => !empty($request->input('start_at_begin'))? $request->input('start_at_begin') : '',
                'start_at_end' => !empty($request->input('start_at_end'))? $request->input('start_at_end') : '',
                'nameProject' => !empty($request->input('nameProject'))? $request->input('nameProject') : '',
                'finish_from' => !empty($request->input('finish_from'))? $request->input('finish_from') : '',
                'finish_to' => !empty($request->input('finish_to'))? $request->input('finish_to') : '',
                'nameTag' => !empty($request->input('nameTag'))? $request->input('nameTag') : '',
            ]);

        }
        return view('auth.login');
    }


    public function adduser(Request $request)
    {
        //add user to projects

        //take a project, add a user to it
        $project = Project::find($request->input('project_id'));


        if (Auth::user()->id == $project->user_id) {

            $user = User::where('email', $request->input('email'))->first(); //single record

            //check if user is already added to the project
            $projectUser = ProjectUser::where('user_id', $user->id)
                ->where('project_id', $project->id)
                ->first();

            if ($projectUser) {
                //if user already exists, exit 
                return redirect()->route('projects.show', ['project' => $project->id])
                    ->with('success', $request->input('email') . ' is already a member of this project');

            }


            if ($user && $project) {

                $project->users()->attach($user->id);

                return redirect()->route('projects.show', ['project' => $project->id])
                    ->with('success', $request->input('email') . ' was added to the project successfully');

            }

        }

        return redirect()->route('projects.show', ['project' => $project->id])
            ->with('errors', 'Error adding user to project');


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id = null)
    {
        $companies = null;
        if (!$company_id) {
            $companies = Company::where('user_id', Auth::user()->id)->get();
        }

        return view('projects.create', ['company_id' => $company_id, 'companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        if (Auth::check()) {
            $project = $this->project->addProject($request);


            if ($project) {
                return redirect()->route('projects.show', ['project' => $project->id])
                    ->with('success', 'project created successfully');
            }

        }

        return back()->withInput()->with('errors', 'Error creating new project');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $data['project'] = Project::find($project->id);
        foreach ($project->staff as $item) {
            $data['staff'][$item->id] = $item;
        }

        $comments = $project->comments->reverse();
        $data['comments'] = $comments;
        $data['project'] = $project;
        $tags = Tag::where('is_deleted', self::IS_ACTIVE)->paginate(10);
        return view('projects.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $project = Project::find($project->id);
        $company = Company::find($project->company_id);

        return view('projects.edit', ['project' => $project, 'company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Project       $project
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, project $project)
    {

        //save data
        $projectUpdate = $this->project->update($request, $project);

        if ($projectUpdate) {
            return redirect()->route('projects.show', ['project' => $project->id])
                ->with('success', 'project updated successfully');
        }

        //redirect
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //

        $findproject = Project::find($project->id);
        if ($findproject->delete()) {

            //redirect
            return redirect()->route('projects.index')
                ->with('success', 'project deleted successfully');
        }

        return back()->withInput()->with('error', 'project could not be deleted');


    }

    public function deleteProject($id)
    {
        if (Auth::check()) {
            $this->project->deleteProject($id);
            return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
        }

        return view('auth.login');
    }

    public function staff($project_id)
    {
        if ($project_id != null) {
            $data['project'] = Project::find($project_id);
            $data['staff'] = Staff::where('is_deleted', self::IS_ACTIVE)->get();
        }

        return view('projects.staff', $data);
    }

    public function addStaff(Request $request)
    {
        if (Auth::check()) {
            $projectStaff = $this->project->addStaffToProject($request);
            if ($projectStaff) {
                return redirect()->route('projects.show', ['project' => $request->project_id])
                    ->with('success', 'add staff successfully');
            }
        }

        return back()->withInput()->with('errors', 'Error add new staff');
    }

    public function deleteProjectStaff($id)
    {
        $findProjectStaff = ProjectStaff::find($id);
        if ($findProjectStaff->delete()) {
            return back()->withInput()->with('success', 'Staff deleted successfully');
        }
        return back()->withInput()->with('error', 'Staff could not be deleted');
    }

    public function tags ($id) {
        if (Auth::check()) {
            $project = Project::where('id',$id)->first();
            $tagSelected = [];
            foreach ($project->project_tag as $key => $tag_id) {  // project_tag() trong model Project
                 $tagSelected[] = $tag_id->tag_id;
            }
            $tags = Tag::all();
            return view('projects.add-tag', ['tags' => $tags, 'project_id' => $id,'tagSelected' => $tagSelected, 'project' => $project]);
        }
        return view('auth.login');
    }

    public function addTags (Request $request) {
        $id = $request->get('project_id');
        $request->validate($this->validator->rule(), $this->validator->message());
        DB::table('project_tag')->where('project_id', $id)->delete();
        $this->project->addTagToProject($request);
        return redirect()->route('projects.show', ['project' => $request->get('project_id')])->with('success', 'Add tag successfully');
    }
}
