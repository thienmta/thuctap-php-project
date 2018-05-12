@extends('layouts.app')

@section('content')

    <div class="col-md-6 col-lg-6 col-md-offset-3  col-lg-offset-3">
        <div class="panel panel-primary ">
            <div class="panel-heading">Staff <a  class="pull-right btn btn-primary btn-sm" href="/staff/create">
                    <i class="fa fa-plus-square" aria-hidden="true"></i>  Create new</a> </div>
            <div class="panel-body">
                {!! $staff->render() !!}
                <ul class="list-group">
                    @foreach($staff as $item)
                        <li class="list-group-item">
                            <i class="fa fa-play" aria-hidden="true"></i>
                            <a href="/staff/{{ $item->id }}" >  {{ $item->full_name }}
                                @if ($item->nick_name != '')
                                    {{ ' - '. $item->nick_name }}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection