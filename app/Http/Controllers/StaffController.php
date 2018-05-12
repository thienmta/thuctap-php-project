<?php

namespace App\Http\Controllers;

use App\Model\Staff;
use App\Repositories\Staff\StaffEloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    const IS_ACTIVE = 0;
    const IS_DELETED = 1;
    private $staff;

    public function __construct(StaffEloquentRepository $staff)
    {
        $this->staff = $staff;
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
            $staff = Staff::where('is_deleted', self::IS_ACTIVE)->paginate(10);
            return view('staff.index', ['staff' => $staff]);
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

        return view('staff.create');
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
            if ($this->is_exist($request->input('nick_name'))) {
                return redirect()->route('staff.create')->withErrors(['Nick name existed']);
            }

            $staff = $this->staff->addStaff($request);
            if ($staff) {
                return redirect()->route('staff.show', ['staff' => $staff->id])
                    ->with('success', 'Staff created successfully');
            }

        }

        return back()->withInput()->with('errors', 'Error creating new staff');

    }

    private function is_exist($nick_name)
    {
        $staff = Staff::where('nick_name', $nick_name)->get()->toArray();
        return (empty($staff)) ? false : true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        $staff = Staff::find($staff->id);

        return view('staff.show', ['staff' => $staff]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
        $staff = Staff::find($staff->id);

        return view('staff.edit', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {

        //save data
        $staffUpdate = $this->staff->editStaff($request, $staff);

        if ($staffUpdate) {
            return redirect()->route('staff.show', ['staff' => $staff->id])
                ->with('success', 'Staff updated successfully');
        }
        //redirect
        return back()->withInput();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //

        $findStaff = Staff::find($staff->id);
        if ($findStaff->delete()) {

            //redirect
            return redirect()->route('staff.index')
                ->with('success', 'Staff deleted successfully');
        }

        return back()->withInput()->with('error', 'Staff could not be deleted');


    }
}
