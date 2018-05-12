<?php

namespace App\Http\Controllers\Analysis;

use App\Model\ProjectStaff;
use App\Model\Staff;
use App\Repositories\Staff\StaffEloquentRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Project\ProjectEloquentRepository;
use Symfony\Component\HttpFoundation\Request;

class GanttController extends Controller
{

    /**
     * @var ProjectEloquentRepository
     */
    private $project;

    public function __construct(ProjectEloquentRepository $project)
    {
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('analysis.gantt',[
            'projects' => $this->project->getActiveProject()
        ]);
    }

    public function statistics(Request $request)
    {
        $current_date = $request->post('current_date');
        if (empty($current_date)) {
            $current_date = date('Y/m/d');
        }
        $start_date = date("Y/m/d",strtotime(date( "Y/m/d", strtotime( $current_date ) ) ."-1 month"));
        $end_date = date("Y/m/d",strtotime(date( "Y/m/d", strtotime( $current_date ) ) ."+2 month"));
        $ser = new StaffEloquentRepository();
        $data = $ser->getTimelineForStaff($start_date, $end_date);

        return view('analysis.statistics',['statistics' => $data, 'current_date' => $current_date]);
    }
}
