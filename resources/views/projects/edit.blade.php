@extends('layouts.app')

@section('content')

    <div class="row col-md-9 col-lg-9 col-sm-9 pull-left "style="background: white;">
        <h1>Update Project </h1>

        <!-- Example row of columns -->
        <div class="row  col-md-12 col-lg-12 col-sm-12">

            <form method="post"
                  action="{{ route('projects.update',[$project->id]) }}">
                {{ csrf_field() }}

                <input type="hidden" name="_method" value="put">

                <div class="form-group">
                    <label for="company-name">Name<span
                                class="required">*</span></label>
                    <input placeholder="Enter name"
                           id="company-name"
                           required
                           name="name"
                           spellcheck="false"
                           class="form-control"
                           value="{{ $project->name }}"
                    />
                </div>

                <div class="form-group">
                    <label for="comment-content">Start date</label>
                    <div class='input-group date col-sm-4' id='datetimepicker_start_at' >
                        <input type='text' name="start_at" class="form-control" value="{{ du()->date($project->start_at) }}"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>

                    <label for="comment-content">Finish date</label>
                    <div class='input-group date col-sm-4' id='datetimepicker_finish_at'>
                        <input type='text' name="finish_at" class="form-control" value="{{ du()->date($project->finish_at) }}"/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>

                </div>

                <div class="form-group">
                    <label for="company-content">Completed</label>
                    <div class='input-group date col-sm-2'>
                        <input type='text' name="completed" class="form-control" value="{{ $project->completed }}"/>
                        <span class="input-group-addon">
                          <span class="glyphicon">%</span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company-content">Description</label>
                    <textarea placeholder="Enter description"
                              style="resize: vertical"
                              id="company-content"
                              name="description"
                              rows="5" spellcheck="false"
                              class="form-control autosize-target text-left">{{ $project->description }}</textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit"/>
                </div>
            </form>


        </div>
    </div>

    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                @if (isset($company))
                    <li><a href="/companies/{{ $company->id }}"><i class="fa fa-building-o" aria-hidden="true"></i> View companies</a></li>
                @endif
                <li><a href="/companies"><i class="fa fa-building" aria-hidden="true"></i> All companies</a>
                </li>
            </ol>
        </div>
    </div>

    <script type="application/javascript">
        $(function () {
            $('#datetimepicker_start_at').datetimepicker({
                viewMode: 'days',
                format: 'YYYY/MM/DD'
            });
            $('#datetimepicker_finish_at').datetimepicker({
                viewMode: 'days',
                format: 'YYYY/MM/DD'
            });
        });
    </script>


@endsection