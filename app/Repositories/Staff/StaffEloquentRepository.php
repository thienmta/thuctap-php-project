<?php
namespace App\Repositories\Staff;

use App\Model\ProjectStaff;
use App\Model\Staff;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: trunghpb
 * Date: 2018/03/05
 * Time: 16:22
 */
class StaffEloquentRepository extends BaseRepository
{


    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Staff::class;
    }

    public function getActiveProject() {
        return $this->all();
    }

    /**
     * @param Request $request
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function addStaff(Request $request)
    {
        $staff = Staff::create([
            'full_name' => $request->input('full_name'),
            'nick_name' => $request->input('nick_name'),
            'user_id' => Auth::user()->id
        ]);
        return $staff;
    }
    
    public function editStaff(Request $request, Staff $staff)
    {
        $staff = Staff::where('id', $staff->id)
            ->update([
                'full_name' => $request->input('full_name'),
                'nick_name' => $request->input('nick_name')
            ]);
        return $staff;
    }

    public function getTimelineForStaff($start_date, $end_date)
    {
        $staff = $this->formatStaffArray(Staff::where('is_deleted', 0)->get()->toArray());

        $project_staff = ProjectStaff::where(function($query) use ($start_date, $end_date){
                $query->where('start_date', '<=', $start_date);
                $query->where('end_date', '>=', $start_date);
            })
            ->orWhere(function($query) use ($start_date, $end_date){
                $query->where('start_date', '>=', $start_date);
                $query->where('end_date', '<=', $end_date);
            })
            ->orWhere(function($query) use ($start_date, $end_date){
                $query->where('start_date', '<=', $end_date);
                $query->where('end_date', '>=', $end_date);
            })
            ->orWhere(function($query) use ($start_date, $end_date){
                $query->where('start_date', '<=', $start_date);
                $query->where('end_date', '>=', $end_date);
            })
            ->get()->toArray();

        return $this->addPeriodForStaff($staff, $project_staff);
    }

    private function formatStaffArray($data)
    {
        $res = [];
        foreach ($data as $item) {
            $res[$item['id']] = $item;
            $res[$item['id']]['periods'] = [];
        }
        return $res;
    }

    public function addPeriodForStaff($staff, $project_staff)
    {
        foreach ($project_staff as $item) {
            if (isset($staff[$item['staff_id']])) {
                $staff[$item['staff_id']]['periods'][] = $item;
            }
        }
        return $staff;
    }
}