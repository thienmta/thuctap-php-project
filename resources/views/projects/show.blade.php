@extends('layouts.app')

@section('content')



    <div class="row col-md-9 col-lg-9 col-sm-9 pull-left ">
        <!-- The justified navigation menu is meant for single line per list item.
             Multiple lines will require custom code not provided by Bootstrap. -->
        <!-- Jumbotron -->
        <div class="well well-lg">
            <h1>{{ $project->name }}</h1>
            <p>[ {{date($project->start_at)}} - {{date($project->finish_at)}} ]</p>
            <p class="lead">{{ $project->description }}</p>
            <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->
        </div>

        <!-- Example row of columns -->
        <div class="row  col-md-12 col-lg-12 col-sm-12"
             style="background: white; margin: 10px; ">
            <!-- <a href="/projects/create" class="pull-right btn btn-default btn-sm" >Add Project</a> -->
            <br/>

            @include('partials.comments')


            <div class="row container-fluid">

                <form method="post" action="{{ route('comments.store') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="commentable_type"
                           value="{{App\Model\Project::class}}">
                    <input type="hidden" name="commentable_id"
                           value="{{$project->id}}">
                    <div class="form-group">
                        <label for="comment-status">status</label>
                        <input type="number" id="comment-status" class="form-control autosize-target text-left" value="0" name="status">
                    </div>

                    <div class="form-group">
                        <label for="comment-work-progress">Work progress</label>
                        <input type="number" id="comment-work-progress" value="0" class="form-control autosize-target text-left" name="progress">
                    </div>

                    <div class="form-group">
                        <label for="comment-content">Comment</label>
                        <textarea placeholder="Enter comment"
                                  style="resize: vertical"
                                  id="comment-content"
                                  name="body"
                                  rows="3" spellcheck="false"
                                  class="form-control autosize-target text-left"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment-content">Proof of work done
                            (Url/Photos)</label>
                        <textarea placeholder="Enter url or screenshots"
                                  style="resize: vertical"
                                  id="comment-content"
                                  name="url"
                                  rows="2" spellcheck="false"
                                  class="form-control autosize-target text-left"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary"
                               value="Submit"/>
                    </div>
                </form>


            </div>


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
                <li><a href="/projects/{{ $project->id }}/edit">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Edit</a></li>
                <li><a href="/projects/create"><i class="fa fa-plus-circle"
                                                 aria-hidden="true"></i> Create new
                        project</a></li>
                <li><a href="/projects"><i class="fa fa-database"
                                           aria-hidden="true"></i> My projects</a>
                </li>
                <li><a href="/projects/{{ $project->id }}/staff"><i
                                class="fa fa-user-o" aria-hidden="true"></i> Add Staff</a></li>
                @if (count($project->project_tag) > 0)
                    <li><a href="/projects/{{ $project->id }}/tags"><i
                                    class="glyphicon glyphicon-tag" aria-hidden="true"></i> Edit Tags</a></li>
                @else
                    <li><a href="/projects/{{ $project->id }}/tags"><i
                                    class="glyphicon glyphicon-tag" aria-hidden="true"></i> Add Tags</a></li>
                @endif
                <br/>


                @if($project->user_id == Auth::user()->id)

                    <li>
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                        <a
                                href="#"
                                onclick="
                  var result = confirm('Are you sure you wish to delete this project?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                        >
                            Delete
                        </a>

                        <form id="delete-form"
                              action="{{ route('projects.destroy',[$project->id]) }}"
                              method="POST" style="display: none;">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}
                        </form>

                    </li>
            @endif
            <!-- <li><a href="#">Add new member</a></li> -->
            </ol>
            <hr/>
            <h4>Team Members</h4>
            <ol class="list-unstyled" id="member-list">
                @foreach($project->project_staff as $ps)
                    <li style="border-bottom: 1px dashed #cccccc">
                        <div>
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <a style="width: 80%" href="/staff/{{$staff[$ps->staff_id]->id}}" data-toggle="tooltip" data-html="true" data-placement="top" title="
                        <table style='width: 100%'>
                            <tr>
                                <td class='text-left'>Start date: {{ $ps->start_date }}</td>
                            </tr>
                            <tr>
                                <td class='text-left'>End date: {{ $ps->end_date }}</td>
                            </tr>
                            <tr>
                                <td class='text-left'>Participation rates: {{ $ps->participation_rates }}%</td>
                            </tr>
                        </table>
                       ">{{$staff[$ps->staff_id]->nick_name}} ({{$staff[$ps->staff_id]->full_name}})</a>
                                    </td>
                                    <td>
                                        <a href="/project_staff_delete/{{ $ps->id }}"><button class="btn-delete-custom" onclick="return confirm('Are you sure you wish to delete this staff?')">x</button></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </li>
                @endforeach
            </ol>
            <hr/>
            <h4>List tags of this project</h4>
            <ul class="list-group list-group-flush">
                @if (count($project->project_tag) > 0)
                    @foreach($project->project_tag as $projectTag)
                        <li class="list-group-item fa fa-tags"><a href="{{route('tag.show', [$projectTag->tags->id])}}"> {{$projectTag->tags->name}}</a></li>
                    @endforeach
                @else
                    <p>No tag</p>
                @endif
            </ul>

        </div>

        <!--<div class="sidebar-module">
          <h4>Members</h4>
          <ol class="list-unstyled">
            <li><a href="#">March 2014</a></li>
          </ol>
        </div> -->
    </div>


@endsection

@section('jqueryScript')
    <script type="text/javascript">

        $('#addMember').on('click', function (e) {
            e.preventDefault(); //prevent the form from auto submit

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });


            var formData = {
                project_id: $('#project_id').val(),
                email: $('#email').val(),
                '_token': $('input[name=_token]').val(),
            }

            var url = '/projects/adduser';

            $.ajax({
                type: 'post',
                url: "{{ URL::route('projects.adduser') }}",
                data: formData,
                dataType: 'json',
                success: function (data) {

                    var emailField = $('#email').val();
                    $('#email').val('');
                    $('#member-list').prepend('<li><a href="#">' + emailField + '</a> </li>');

                },
                error: function (data) {
                    //do something with data
                    console.log("error sending request" + data.error);
                }
            });


        });

    </script>


@endsection







