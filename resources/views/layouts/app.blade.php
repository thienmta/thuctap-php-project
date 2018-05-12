<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('moment/moment.js') }}"></script>
    <script src="{{ asset('moment/moment-with-locales.js') }}"></script>
    <script src="{{ asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="https://use.fontawesome.com/874dbadbd7.js"></script>
    <style>
        .btn-delete-custom {
            background: none;
            border: none;
            outline: none;
            color: red;
            float: right;
        }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest

                    <li><a href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i>
                            Register</a></li>
                    @else
                        <li><a class="nav-link" href="{{ route('tag.index') }}"><i class="fa fa-tags" aria-hidden="true"></i>Tags</a></li>
                        <li><a class="nav-link" href="{{ route('staff.index') }}"><i class="fa fa-building" aria-hidden="true"></i>Staff</a></li>
                        <li><a class="nav-link" href="{{ route('companies.index') }}"><i class="fa fa-building" aria-hidden="true"></i>Companies</a></li>
                        <li><a class="nav-link" href="{{ route('projects.index') }}"><i class="fa fa-briefcase" aria-hidden="true"></i>Projects</a></li>
                        <li><a class="nav-link" href="{{ route('tasks.index') }}"><i class="fa fa-tasks" aria-hidden="true"></i>Tasks</a></li>
                        <li><a class="nav-link" href="{{ route('analysis.index') }}"><i class="fa fa-outdent" aria-hidden="true"></i>Project Gantt</a></li>
                        <li><a class="nav-link" href="{{ route('statistics.index') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i>Human Resource Chart</a></li>
                        @if(Auth::user()->role_id == 1)

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle"
                               data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                Admin <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('projects.index') }}"><i class="fa fa-briefcase" aria-hidden="true"></i> All Projects</a></li>
                                <li><a href="{{ route('users.index') }}"><i class="fa fa-user" aria-hidden="true"></i> All Users</a></li>
                                <li><a href="{{ route('tasks.index') }}"><i class="fa fa-tasks" aria-hidden="true"></i> All Tasks</a></li>
                                <li><a href="{{ route('companies.index') }}"><i class="fa fa-building" aria-hidden="true"></i> All Companies</a></li>
                                <li><a href="{{ route('tag.index') }}"><i class="fa fa-tags" aria-hidden="true"></i> All Tag</a></li>
                                <li><a href="{{ route('staff.index') }}"><i class="fa fa-building" aria-hidden="true"></i> All Staff</a></li>
                                <li><a href="{{ route('roles.index') }}"><i class="fa fa-envelope" aria-hidden="true"></i> All Roles</a></li>
                            </ul>
                        </li>

                        @endif
                        <li class="dropdown">
                            <a class="dropdown-toggle" type="button" data-toggle="dropdown">
                                <span class="text-danger">{{ Auth::user()->name }}</span>
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off"
                                           aria-hidden="true"></i> Logout
                                    </a>

                                    <form id="logout-form"
                                          action="{{ route('logout') }}"
                                          method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <div class="container">
        @include('partials.errors')
        @include('partials.success')

        <div class="row">
            @yield('content')

        </div>
    </div>
</div>
@yield('jqueryScript')
</body>
</html>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>