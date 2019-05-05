@extends('layouts.3columns')

@section('title')
    <title>Aministrator | {{ Auth::user()->name }}</title>
@endsection

@section('center')
    <div class="container-fluid">
        <div class="row pad-top-25">
            <div class="col-12">
                <h2 class="h2-responsive">Dashboard</h2>
            </div>
        </div>
        <div class="row pad-top-25">
            <div class="col-md-5 center-align">
                <h1 class="fa-4x no-margin">{{ number_format($params['users']['all']) }}</h1>
                <span class="badge green white-text">Users</span>
            </div>
            <div class="col-md-7">
                <ul class="list-group">
                    <!-- admin -->
                    <li class="list-group-item pad-0 no-margin no-border transparent semi-bold">Administrators</li>
                    <li class="list-group-item pad-0">
                        <div class="amber darken-1" style="height:5px;width:{{ $params['users']['admins'] }}%;"></div>
                    </li>
                    <!-- moderators -->
                    <li class="list-group-item pad-0 no-margin no-border transparent semi-bold">Moderators</li>
                    <li class="list-group-item pad-0">
                        <div class="purple darken-2" style="height:5px;width:{{ $params['users']['moderators'] }}%;"></div>
                    </li>
                    <!-- Instructors -->
                    <li class="list-group-item pad-0 no-margin no-border transparent semi-bold">Instructors</li>
                    <li class="list-group-item pad-0">
                        <div class="cyan darken-4" style="height:5px;width:{{ $params['users']['instructors'] }}%;"></div>
                    </li>
                    <!-- Students -->
                    <li class="list-group-item pad-0 no-margin no-border transparent semi-bold">Students</li>
                    <li class="list-group-item pad-0">
                        <div class="blue" style="height:5px;width:{{ $params['users']['students'] }}%;"></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row pad-top-50">
            <div class="col-md-6 mx-auto center-align border-right">
                <div class="row">
                    <div class="col-6 center-align">
                        <h1 class="fa-2x">{{ number_format(count($params['courses'])) }}</h1>
                        <label class="badge blue">Courses</label>
                    </div>
                    <div class="col-6 no-overflow pad-0">
                        <ul class="list-group pad-0">
                            @foreach($params['courses'] as $course)
                                <li class="list-group-item pad-0 no-border transparent left-align grey-text no-margin" style="font-size:13px">-&nbsp;{{$course->course_title}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mx-auto center-align">
                <h1 class="fa-2x">{{ number_format($params['classes']) }}</h1>
                <label class="badge amber darken-2">Classes</label>
            </div>
        </div>
    </div>
@endsection