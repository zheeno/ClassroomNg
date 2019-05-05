@extends('layouts.3columns')

@section('title')
    <title>Aministrator | Users | {{ $params['title'] }}</title>
@endsection

@section('center')
    <div class="container-fluid">
        <div class="row pad-top-25">
            <div class="col-12">
                <h2 class="h2-responsive">Users @if(!is_null($params['title']))| {!! $params['title'] !!} @endif</h2>
                @if(session('error'))<div class="alert alert-danger">{!! session('error') !!}</div>@endif
                @if(session('success'))<div class="alert alert-success">{!! session('success') !!}</div>@endif
                <!-- search bar -->
                <form class="row bg-white" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);" action="{{route('admin.searchUsers')}}" method="GET">
                    @csrf
                    <div class="col-md-8" style="padding:0px;padding-top:10px;">
                        <input name="q" type="text" class="form-control no-border no-radius" placeholder="Search Users" required/>
                    </div>
                    <div class="col-md-4 center-align" style="padding:0px;padding-bottom:10px">
                        <button class="btn btn-primary btn-md capitalize no-radius" style="top:7px;position:relative" type="submit"><span class="fa fa-search"></span> Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row pad-top-25">
            @if(count($params['users']) == 0)
                <div class="center-align col-12 pad-top-25">
                    <span class="fa fa-info-circle fa-2x grey-text"></span>
                    <h5 class="h5-responsive">No user found</h5>
                </div>
            @else
                @foreach($params['users'] as $user)
                    <a href="/admin/users/{{ $user->id }}" class="col-md-auto m-3 mx-auto card transparent pad-0" style="min-width: 250px !important;margin-bottom:20px">
                        <div class="card-header transparent pad-0 no-border" style="z-index:1">
                            <div class="medium-circle bg-dark footer" style="@if(count($user->myAvatar) > 0) background-image:url('{{$user->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif text-align:center;border:3px solid #FFF;">
                                <!-- profile pic -->
                                @if(count($user->myAvatar) == 0)<span class="fa-4x white-text m-2">{{substr($user->name, 0, 1)}}</span>@endif
                            </div>
                        </div>
                        <div class="card-body p-3 @if($user->isStudent()) blue @elseif($user->isInstructor()) cyan darken-4 @elseif($user->isModerator()) purple darken-4 @elseif($user->isAdmin()) amber darken-1 @endif" style="z-index:0;margin-top: -45px;padding-top: 50px !important;padding: 50px 10px 0px !important;margin-bottom: 0px !important;text-align: center;">
                            <span class="badge no-shadow white-text">
                                @if($user->isStudent())
                                    Student
                                @elseif($user->isInstructor())
                                    Instructor
                                @elseif($user->isModerator())
                                    Moderator
                                @elseif($user->isAdmin())
                                    Administrator
                                @endif
                            </span>
                            <h3 class="m-1 h3-responsive semi-bold white-text">{{ $user->name }}</h3>
                            <div class="p-3">
                                @if($user->high_deg != null)
                                    <small class="note white-text">{{ $user->high_deg }} @if($user->inst_high_deg != null) ({{ $user->inst_high_deg }}) @endif</small><br>
                                @endif
                                @if($user->other_deg != null)
                                    <small class="note white-text">{{ $user->other_deg }}</small><br>
                                @endif
                                @if($user->first_deg != null)
                                    <small class="note white-text">{{ $user->first_deg }}</small>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        <div class="row pad-top-25">
            <div class="col-12">{{ $params['users']->links() }}</div>
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