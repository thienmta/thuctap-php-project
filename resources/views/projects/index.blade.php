@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="panel panel-primary ">
            <div class="panel-body clearfix">
                <form method="get" action="{{ route('projects.index') }}">
                    <div class="col-md-6">
                        <div class="form-group ">

                            <div class="form-inline">

                                <label class="col-md-4" for="comment-content">Start from</label>
                                <div class='input-group date col-sm-4' id='datetimepicker_start_at'>
                                    <input type='text' name="start_at_begin" class="form-control" value="{{$start_at_begin}}"/>
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="form-inline">

                                <label class="col-md-4" for="comment-content">Start to</label>
                                <div class='input-group date col-sm-4' id='datetimepicker_finish_at'>
                                    <input type='text' name="start_at_end" class="form-control" value="{{$start_at_end}}"/>
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>

                            </div>

                        </div>

                        <div class="form-group ">
                            <div class="form-inline">

                                <label class="col-md-4" for="comment-content">Name project</label>
                                <div class='input-group col-sm-4'>
                                    <input type='text' name="nameProject" class="form-control" value="{{$nameProject}}" placeholder="Enter name project"/>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="form-inline">

                                <label class="col-md-4" for="comment-content">Finish from</label>
                                <div class='input-group date col-sm-4' id='datetimepicker_finish_begin'>
                                    <input type='text' name="finish_from" class="form-control" value="{{$finish_from}}"/>
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group ">
                            <div class="form-inline">

                                <label class="col-md-4" for="comment-content">Finish to</label>
                                <div class='input-group date col-sm-4' id='datetimepicker_finish_end'>
                                    <input type='text' name="finish_to" class="form-control" value="{{$finish_to}}"/>
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group ">
                            <div class="form-inline">

                                <label class="col-md-4" for="comment-content">Name tag</label>
                                <div class='input-group col-sm-4'>
                                    <input type='text' name="nameTag" class="form-control" value="{{$nameTag}}" placeholder="Enter name tag"/>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">


                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" value="Search"/>
                            <button class="btn btn-default" ><a href="{{ route('projects.index') }}">Cancel</a></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <span class="pull-left">Projects</span>
                <a class="pull-right btn btn-primary btn-sm" href="/projects/create">Create new</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-md-push-6">
                        <form method="get" action="{{route('projects.index')}}">
                            {{csrf_field()}}
                            <b>Number of projects displayed</b>
                            <input type='text' name="numberOfProjects" class="form-control" value="" placeholder="Enter number of projects"/>
                            <div class="row">
                                <div class="col-md-3" style="float: left;">
                                    <input type="submit" class="btn btn-default" value="Show" />
                                </div>
                                <div class="col-md-8" style="float: right;">
                                    {{$projects->links()}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                @if (count($projects) > 0)
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Start at</th>
                            <th>Finish at</th>
                            <th>Complete</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($projects as $key => $project)

                                <tr>
                                    <td><a href="/projects/{{ $project->id }}">{{ $project->id }}</a>
                                    </td>
                                    <td><a href="/projects/{{ $project->id }}">{{ $project->name }}</a>
                                    </td>
                                    @if (isset($project->company))
                                        <td><a href="/companies/{{ $project->company->id }}">{{ $project->company->name }}</a>
                                        </td>
                                    @else
                                        <td>No company</td>
                                    @endif
                                    <td>{{ $project->start_at }}
                                    </td>
                                    <td>{{ $project->finish_at }}
                                    </td>
                                    <td>{{ $project->completed }} %
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-delete" data-Action="{{ route('projects.deleteProject', [$project->id]) }}" data-projectId="{{$project->id}}" data-nameProject="{{$project->name}}" data-toggle="modal" data-target="#exampleModal">
                                            Delete <span class="glyphicon glyphicon-trash deleteRow"></span>
                                        </button>


                                    </td>
                                    {{--<li class="list-group-item comment">--}}
                                    {{--@if(isset($project->comments[0]))--}}
                                    {{--<div style="padding-left: 10px" class="media-body">--}}
                                    {{--<b> Comment: </b>--}}
                                    {{--<p>--}}
                                    {{--{!! nl2br(e($project->comments[0]->body)) !!}--}}
                                    {{--</p>--}}
                                    {{--<b> Proof: </b>--}}
                                    {{--<p>--}}
                                    {{--{{ $project->comments[0]->url }}--}}
                                    {{--</p>--}}
                                    {{--</div>--}}
                                    {{--@endif--}}
                                    {{--</li>--}}
                                </tr>

                        @endforeach
                        </tbody>

                    </table>
                @else
                    <b>Project not found !</b>
                @endif

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="formDelete" action="" method="POST" >
                                {{ csrf_field() }}
                                <input type="hidden" name="project_id" value="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Delete project</b></h5>
                                </div>
                                <div class="modal-body">
                                    Do you want delete project <b id="nameProject"></b> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnDelete" onclick="disableBtn()">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
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
            $('#datetimepicker_finish_begin').datetimepicker({
                viewMode: 'days',
                format: 'YYYY/MM/DD'
            });
            $('#datetimepicker_finish_end').datetimepicker({
                viewMode: 'days',
                format: 'YYYY/MM/DD'
            });
        });

        $(".comment i").click(function () {
            $(this).parent().find(".media-body").toggle("slow", function () {
            });

            if ($(this).hasClass('fa-plus-square')) {
                $(this).addClass('fa-minus-square').removeClass('fa-plus-square')
            } else {
                $(this).addClass('fa-plus-square').removeClass('fa-minus-square')
            }
        });

        $(".btn-delete").click(function () {
            console.log($(this).attr('data-Action'));
            $("#exampleModal").find('input[name = "project_id"]').val($(this).attr('data-projectId'));
            $("#exampleModal").find('#nameProject').text($(this).attr('data-nameProject'));
            $("#exampleModal").find('#formDelete').attr('action', $(this).attr('data-Action'));
        })

        function disableBtn () {
            $("#formDelete").submit();
            $("#btnDelete").attr('disabled', 'disabled');
            // document.getElementById("formDelete").submit();
            // document.getElementById("btnDelete").disabled = true;
        }

    </script>

@endsection