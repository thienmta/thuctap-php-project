@extends('layouts.app')

@section('content')




    <div class="row col-md-9 col-lg-9 col-sm-9 pull-left " style="background: white;">
        <h1>Create new staff </h1>

        <!-- Example row of columns -->
        <div class="row  col-md-12 col-lg-12 col-sm-12" >

            <form method="post" action="{{ route('staff.store') }}">
                {{ csrf_field() }}


                <div class="form-group">
                    <label for="company-name">Full Name<span class="required">*</span></label>
                    <input   placeholder="Enter full name"
                             id="staff-full-name"
                             required
                             name="full_name"
                             spellcheck="false"
                             class="form-control"
                    />
                </div>

                <div class="form-group">
                    <label for="company-name">Nick Name<span class="required">*</span></label>
                    <input   placeholder="Enter nick name"
                             id="staff-nick-name"
                             required
                             name="nick_name"
                             spellcheck="false"
                             class="form-control"
                    />
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary"
                           value="Submit"/>
                </div>
            </form>


        </div>
    </div>


    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="/staff"> <i class="fa fa-building-o" aria-hidden="true"></i> My staff</a></li>

            </ol>
        </div>
    </div>


@endsection