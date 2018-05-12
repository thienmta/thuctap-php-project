@extends('layouts.app')

@section('content')



    <div class="row col-md-9 col-lg-9 col-sm-9 pull-left " style="background: white; ">
        <h1>Create new project </h1>

        <!-- Example row of columns -->
        <div class="row  col-md-12 col-lg-12 col-sm-12">
            <form method="post" action="/projects/add_staff">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="company-content">Select staff</label>
                    <select name="staff_id" class="form-control">
                        @foreach($staff as $item)
                            <option value="{{$item->id}}"> {{$item->full_name}} - {{$item->nick_name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date">Start date</label>
                    <input placeholder="Enter start date"
                           id="start_date"
                           name="start_date"
                           spellcheck="false"
                           class="form-control datepicker"
                    />
                </div>
                <div class="form-group">
                    <label for="end_date">End date</label>
                    <input placeholder="Enter start date"
                           id="end_date"
                           name="end_date"
                           spellcheck="false"
                           class="form-control datepicker"
                    />
                </div>
                <div class="form-group">
                    <label for="company-content">Participation rates</label>
                    <div class='input-group date col-sm-2'>
                        <input type='number' name="participation_rates" class="form-control" value="0"/>
                                     <span class="input-group-addon">
                                              <span class="glyphicon">%</span>
                                            </span>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="project_id" value="{{ $project->id }}"/>
                    <input type="submit" class="btn btn-primary"
                           value="Submit"/>
                </div>
            </form>
        </div>
    </div>


    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
        <!--<div class="sidebar-module sidebar-module-inset">
          <h4>About</h4>
          <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div> -->
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="/projects"><i class="fa fa-user-o" aria-hidden="true"></i> My projects</a></li>

            </ol>
        </div>

        <!--<div class="sidebar-module">
          <h4>Members</h4>
          <ol class="list-unstyled">
            <li><a href="#">March 2014</a></li>
          </ol>
        </div> -->
    </div>


@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('.datepicker').datetimepicker({
            format: 'YYYY/MM/DD H:s'
        });
    });
</script>