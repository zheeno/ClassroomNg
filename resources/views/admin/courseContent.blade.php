@extends('layouts.3columns')

@section('title')
    <title>Aministrator | Courses | {{ $params['course']->course_title }}</title>
@endsection

@section('center')
    <div class="container-fluid">
        <div class="row pad-top-25">
            <div class="col-12 dropdown">
                <a href="{{ route('admin.viewCourses') }}" class="btn-link h2-responsive">Courses</a>&nbsp;
                <a class="h2-responsive" data-toggle="dropdown">/ {{ $params['course']->course_title }}</a>
                <a class="btn btn-sm no-shadow pad-0" style="margin-top:-5px" data-toggle="dropdown"><span class="fa fa-caret-down"></span></a>
                <div class="dropdown-menu pad-0">
                    <ul class="list-group pad-0">
                        @foreach($params['courses'] as $course)
                            <a class="list-group-item @if($course->id == $params['course']->id) disabled @endif" href="/admin/viewCourses/{{$course->id}}">
                                {{$course->course_title}}
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @if(session('error'))<div class="alert alert-danger">{!! session('error') !!}</div>@endif
            @if(session('success'))<div class="alert alert-success">{!! session('success') !!}</div>@endif
        </div>
        <div class="row pad-top-25">
            <div class="col-md-12 col-lg-6 center-align">
                <h1 class="bold h1-responsive no-margin">{{ number_format(count($params['course']->allClasses)) }}</h1>
                <small>Classes</small>
            </div>
            <div class="col-md-12 col-lg-6 center-align">
                <h1 class="bold h1-responsive no-margin">{{ number_format(count($params['course']->subscription)) }}</h1>
                <small>Subscribers</small>
            </div>
        </div>
        <div class="row pad-top-25">
            <!-- description -->
            <div class="col-12">
                <span class="note">{!! $params['course']->description !!}</span>
            </div>
        </div>
        <div class="row pad-top-25">
            @if(count($params['classes']) == 0)
                <div class="col-12 pad-top-100 center-align">
                    <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                    <h4 class="h4-responsive grey-text">
                        We could not find any data relating to the 
                        selected course in our Knowledge base.<br>
                    </h4>
                </div>
            @else
                @foreach($params['classes'] as $class)
                    @include('components/feed')
                @endforeach
            @endif
        </div>
        <div class="row pad-top-25">
            {{ $params['classes']->links() }}
        </div>
    </div>
@endsection

@section('right')
    <div class="p-2 purple darken-3" style="margin-top:-10px">
        <span class="lead white-text">Moderators</span>
        <a class="btn p-1 btn-sm btn-grey transparent m-0 pull-right no-shadow" data-toggle="collapse" data-target="#addModCol"><span class="fa fa-plus white-text"></span></a>
    </div>
    <div id="addModCol" class="collapse">
        <form class="dropdown" method="POST" action="{{ route('admin.addModerator') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{$params['course']->id}}" required/>
            <input id="modId" type="hidden" name="moderator_id" required/>
            <div class="list-group-item p-2" data-toggle="dropdown">
                <small id="modName">Select Moderator</small>
                <span class="fa fa-angle-down pull-right m-1"></span>
            </div>
            <div class="dropdown-menu w-100 m-0 p-0">
                @foreach($params['allModerators'] as $moderator)
                    <li data-id="{{ $moderator->id }}" data-name="{{ $moderator->name }}" class="modSelector list-group-item p-2 m-0 transparent waves-effect wave-slight" style="font-size:14px;color:#666">{{$moderator->name}}</li>
                @endforeach
            </div>
            <center>
                <button type="submit" class="modSelSubBtn disabled btn btn-sm btn-purple capitalize" disabled><span class="fa fa-plus"></span> Add Moderator</button>
            </center>
        </form>
    </div>
    @if(count($params['moderators']) == 0)
        <div class="pad-top-25 center-align">
            <span class="fa fa-info-circle fa-2x grey-text"></span>
            <br>
            <span class="black-text">You haven&apos;t assigned a moderator to this course</span>
        </div>
    @else
        <ul class="list-group">
            @foreach($params['moderators'] as $moderator)
                <li class="list-group-item black-text p-0"><a data-id="{{ $moderator->id }}" data-course-id="{{ $params['course']->id }}" class="remModBtn btn btn-sm btn-danger p-1 no-shadow"><span class="fa fa-times-circle"></span></a>
                    <a class="black-text" href="/admin/users/{{ $moderator->id }}">{{ $moderator->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif
    <ul class="pad-0 pad-top-25">
        <a data-course-id="{{ $params['course']->id }}" class="edit-course-btn grey lighten-4 no-border waves-effect waves-strong btn-block m-0 semi-bold list-group-item capitalize"><span class="fa fa-edit blue-text"></span> Edit Course</a>
        <a data-course-id="{{ $params['course']->id }}" class="delete-course-btn grey lighten-4 no-border waves-effect waves-strong btn-block m-0 semi-bold list-group-item capitalize"><span class="fa fa-trash red-text"></span> Delete Course</a>
    </ul>
@endsection