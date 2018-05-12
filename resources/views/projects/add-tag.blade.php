@extends('layouts.app')

@section('content')

    <div class="col-md-6 col-lg-6 col-md-offset-3  col-lg-offset-3">
        <form action="{{route('projects.addTags')}}" method="post">
            {{csrf_field()}}
            <div class="panel panel-primary ">
                <div class="panel-heading">Tags List<a  class="pull-right btn btn-primary btn-sm" href="/tag/create">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Create new</a> </div>
                <div class="panel-body">
                    <p>Choose tags for project: <b>{{$project->name}}</b></p>
                    @if (!empty($tags))
                        @foreach ($tags as $item)
                                    <?php $checked = in_array($item->id, $tagSelected) ? 'checked' : ''?>
                                    <input type="checkbox" name="tags[]" value="{{$item->id}}" {{$checked}}> {{$item->name}}<br>
                        @endforeach
                    @else
                        <p>No tag</p>
                    @endif

                </div>
                <input type="hidden" name="project_id" value="{{$project_id}}">
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>

@endsection