@extends('layouts.app')

@section('content')



    <div class="row col-md-9 col-lg-9 col-sm-9 pull-left ">
        <!-- The justified navigation menu is meant for single line per list item.
             Multiple lines will require custom code not provided by Bootstrap. -->
        <!-- Jumbotron -->
        <div class="jumbotron" >
            <h1>{{ $staff->full_name }}</h1>
            <p class="lead">{{ $staff->nick_name }}</p>
            <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->
        </div>

        <!-- Example row of columns -->

    </div>


    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
        <!--<div class="sidebar-module sidebar-module-inset">
          <h4>About</h4>
          <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div> -->
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="/staff/{{ $staff->id }}/edit">Edit</a></li>
                <li><a href="/staff/create">Create new staff</a></li>

                <br/>


                <li>


                    <a
                            href="#"
                            onclick="
                  var result = confirm('Are you sure you wish to delete this Staff?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                    >
                        Delete
                    </a>

                    <form id="delete-form" action="{{ route('staff.destroy',[$staff->id]) }}"
                          method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
                    </form>




                </li>

                <!-- <li><a href="#">Add new member</a></li> -->
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