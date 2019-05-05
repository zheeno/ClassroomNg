@extends('layouts.3columns')

@section('title')
    <title>Aministrator | Users | {{ $params['user']->name }}</title>
@endsection

@section('center')
    <div class="container-fluid">
        <div class="row pad-top-25">
            <div class="col-12">
                <a href="{{ route('admin.allUsers') }}" class="h2-responsive">Users</a> <span class="h2-responsive">/ {{ $params['user']->name }}</span>
                @if(session("success"))
                    <div class="alert alert-success">{!! session("success") !!}</div>
                @endif
            </div>
        </div>
        <div class="row pad-0 pad-top-25 @if($params['user']->isStudent()) blue @elseif($params['user']->isInstructor()) cyan darken-4 @elseif($params['user']->isModerator()) purple darken-4 @elseif($params['user']->isAdmin()) amber darken-1 @endif" style="margin-top:75px">
            <div class="col-12 center-align" style="padding-bottom:10px">
                <div class="medium-circle bg-dark footer" style="@if(count($params['user']->myAvatar) > 0) background-image:url('{{$params['user']->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif border:3px solid #FFF; margin-top:-75px">
                    <!-- profile pic -->
                </div>
                <h3 class="h3-responsive semi-bold white-text">{{ $params['user']->name }}</h3>
                <div style="margin-top:-12px">
                    @if($params['user']->high_deg != null)
                        <small class="note white-text">{{ $params['user']->high_deg }} @if($params['user']->inst_high_deg != null) ({{ $params['user']->inst_high_deg }}) @endif</small><br>
                    @endif
                    @if($params['user']->other_deg != null)
                        <small class="note white-text" style="top:-7px;position:relative">{{ $params['user']->other_deg }}</small><br>
                    @endif
                    @if($params['user']->first_deg != null)
                        <small class="note white-text" style="top:-14px;position:relative">{{ $params['user']->first_deg }}</small>
                    @endif
                </div>
            </div>
            <div class="col-12 grey lighten-2 p-0">
                <div class="navbar p-0 m-0 no-shadow">
                    <a data-user-id="{{ $params['user']->id }}" class="user-acc-del-btn btn transparent waves-effect waves-strong no-radius no-shadow btn-md transparent m-0 capitalize"><span class="fa fa-trash black-text"></span> Delete Account</a>
                    <form id="changePermForm" class="dropdown" method="POST" action="{{ route('admin.changePerm') }}">
                        <a data-toggle="dropdown" class="btn transparent waves-effect waves-strong no-radius no-shadow btn-md transparent m-0 capitalize"><span class="fa fa-compress black-text"></span> 
                            <span id="permSelName">
                                @if($params['user']->isStudent())
                                    Student
                                @elseif($params['user']->isInstructor())
                                    Instructor
                                @elseif($params['user']->isModerator())
                                    Moderator
                                @elseif($params['user']->isAdmin())
                                    Administrator
                                @endif
                            </span>
                            <span class="fa fa-caret-down m-1 pull-right"></span>
                        </a>
                        <div class="dropdown-menu p-0">
                            <ul class="list-group p-0">
                                <li class="permSelector list-group-item p-1" style="border-left: 3px solid #ffb300;" data-code="755" data-name="Administrator">Administrator<span class="fa fa-angle-right pull-right m-1"></span></li>
                                <li class="permSelector list-group-item p-1" style="border-left: 3px solid #4a148c;" data-code="702" data-name="Moderator">Moderator<span class="fa fa-angle-right pull-right m-1"></span></li>
                                <li class="permSelector list-group-item p-1" style="border-left: 3px solid #006064;" data-code="701" data-name="Instructor">Instructor<span class="fa fa-angle-right pull-right m-1"></span></li>
                                <li class="permSelector list-group-item p-1" style="border-left: 3px solid #2196f3;" data-code="700" data-name="Student">Student<span class="fa fa-angle-right pull-right m-1"></span></li>
                            </ul>
                        </div>
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $params['user']->id }}" required/>
                        <input id="newPerm" type="hidden" name="newPerm" required/>
                        <button type="button" class="disabled permModBtn btn btn-black btn-sm p-2 m-0" disabled><span class="fa fa-save white-text"></span></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row p-2">
            <!-- moderator -->
            @if($params['user']->isModerator())
                <div class="col-md-auto mx-auto card p-0">
                    <div class="card-header purple darken-3">
                        <h5 class="h5-responsive white-text">Assigned Courses</h5>
                    </div>
                    <div class="card-body p-2">
                        @if(count($params['user']->assignedCourses) == 0)
                            <div class="center-align">
                                <span class="fa fa-info-circle"></span>
                                <h5 class="h5-responsive">This moderator has not been assigned any courses</h5>
                            </div>
                        @else
                            @foreach($params['user']->assignedCourses as $assigned)
                                <li data-href="/admin/viewCourses/{{$assigned->course->id}}" class="link list-group-item black-text p-1 waves-effect waves-strong no-border">
                                    {{ $assigned->course->course_title}}
                                    <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
                                </li>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
            <!-- instructor -->
            @if($params['user']->isInstructor())
                <div class="col-md-auto mx-auto card p-0">
                    <div class="card-header cyan darken-4">
                        <h5 class="h5-responsive white-text">Classes</h5>
                    </div>
                    <div class="card-body p-2">
                        @if(count($params['user']->myClasses) == 0)
                            <div class="center-align">
                                <span class="fa fa-info-circle"></span>
                                <h5 class="h5-responsive">This moderator has not been assigned any courses</h5>
                            </div>
                        @else
                            @foreach($params['user']->myClasses as $class)
                                <li data-href="/classes/{{$class->id}}" class="link list-group-item black-text p-1 waves-effect waves-strong no-border">{{ $class->class_title}}
                                    @if($class->status == "PENDING")<span class="fa fa-clock-o orange-text pull-right m-1" style="font-size:15px"></span>@endif
                                    @if($class->status == "REJECTED")<span class="fa fa-warning red-text pull-right m-1" style="font-size:15px"></span>@endif
                                    @if($class->status == "APPROVED")<span class="fa fa-check-circle green-text pull-right m-1" style="font-size:15px"></span>@endif
                                </li>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- followers -->
                <div class="col-md-auto mx-auto card">
                    <div class="card-body center-align">
                        <h1 class="fa-4x">{{ number_format(count($params['user']->myFollowers)) }}
                    </div>
                    <div class="card-footer no-border p-0 center-align transparent">
                        <h5 class="badge cyan darken-4"><span class="white-text">Followers</span></h5>
                    </div>
                </div>
            @endif
            <!-- student -->
            @if($params['user']->isStudent())
                <div class="col-md-auto mx-auto card p-0">
                    <div class="card-header blue">
                        <h5 class="h5-responsive white-text">Subscribed Courses</h5>
                    </div>
                    <div class="card-body p-2">
                        @if(count($params['user']->courseList) == 0)
                            <div class="center-align">
                                <span class="fa fa-info-circle"></span>
                                <h5 class="h5-responsive">This student has not subscribed to any of our courses</h5>
                            </div>
                        @else
                            @foreach($params['user']->courseList as $listItem)
                                <li data-href="/admin/viewCourses/{{$listItem->course->id}}" class="link list-group-item black-text p-1 waves-effect waves-strong no-border">
                                    {{ $listItem->course->course_title}}
                                    <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
                                </li>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- following -->
                <div class="col-md-auto mx-auto card p-0">
                    <div class="card-header blue">
                        <h5 class="h5-responsive white-text">Following</h5>
                    </div>
                    <div class="card-body">
                        @if(count($params['user']->instructorSubscription) == 0)
                            <div class="center-align">
                                <span class="fa fa-info-circle"></span>
                                <h5 class="h5-responsive">This student is currently not following any instrucroe</h5>
                            </div>
                        @else
                            @foreach($params['user']->instructorSubscription as $follow)
                                <li data-href="/admin/users/{{$follow->instructor->id}}" class="link list-group-item black-text p-1 waves-effect waves-strong no-border">
                                    {{ $follow->instructor->name}}
                                    <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
                                </li>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('right')
<div class="pad-0"  style="margin-top:-10px">
    <h5 class="h5-responsive m-2 semi-bold"><span class="fa fa-filter"></span> Filter Users</h5>
    <ul class="list-group" style="background-color: #212121e6;">
        <a href="/admin/users" class="list-group-item transparent p-2 white-text waves-effect waves-light">
            All Users
            <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
        </a>
        <a href="/admin/users/755/get" class="waves-effect waves-slight list-group-item transparent p-2 white-text waves-effect waves-light">
            Administrators
            <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
        </a>
        <a href="/admin/users/702/get" class="waves-effect waves-slight list-group-item transparent p-2 white-text waves-effect waves-light">
            Moderators
            <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
        </a>
        <a href="/admin/users/701/get" class="waves-effect waves-slight list-group-item transparent p-2 white-text waves-effect waves-light">
            Instructors
            <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
        </a>
        <a href="/admin/users/700/get" class="waves-effect waves-slight list-group-item transparent p-2 white-text waves-effect waves-light">
            Students
            <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
        </a>
    </ul>
</div>
@endsection