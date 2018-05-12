@extends('layouts.app')

@section('content')



    <div class="row col-md-9 col-lg-9 col-sm-9 pull-left " style="background: white;">
        <h1>Update tag </h1>

        <!-- Example row of columns -->
        <div class="row  col-md-12 col-lg-12 col-sm-12" >

            <form method="post" action="{{ route('tag.update',[$tag->id]) }}">
                {{ csrf_field() }}

                <input type="hidden" name="_method" value="put">

                <div class="form-group">
                    <label for="staff-full-name">Name<span class="required">*</span></label>
                    <input   placeholder="Enter name"
                             id="name"
                             required
                             name="name"
                             spellcheck="false"
                             class="form-control"
                             value="{{ $tag->name }}"
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
        <!--<div class="sidebar-module sidebar-module-inset">
          <h4>About</h4>
          <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div> -->
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="/tag/{{ $tag->id }}"><i class="fa fa-building-o" aria-hidden="true"></i>
                        View staff</a></li>
                <li><a href="/tag"><i class="fa fa-building" aria-hidden="true"></i> All tag</a></li>

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