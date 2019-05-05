@extends('layouts.3columns')

@section('title')
    <title>Aministrator | Courses</title>
@endsection

@section('center')
    <div class="container-fluid">
        <div class="row pad-top-25">
            <div class="col-12">
                <h2 class="h2-responsive">Courses @if(!is_null($params['title']))| {!! $params['title'] !!} @endif</h2>
                @if(session("success"))<div class="alert alert-success">{!! session("success") !!}</div>@endif
                @if(session("error"))<div class="alert alert-error">{!! session("error") !!}</div>@endif
                <!-- search bar -->
                <form class="row bg-white" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);" action="{{route('admin.searchCourses')}}" method="GET">
                    @csrf
                    <div class="col-md-8" style="padding:0px;padding-top:10px;">
                        <input name="q" type="text" class="form-control no-border no-radius" placeholder="Search Courses" required/>
                    </div>
                    <div class="col-md-4 center-align" style="padding:0px;padding-bottom:10px">
                        <button class="btn btn-primary btn-md capitalize no-radius" style="top:7px;position:relative" type="submit"><span class="fa fa-search"></span> Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row pad-top-25">
            @if(count($params['courses']) == 0)
                <div class="col-12 pad-top-100 center-align">
                    <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                    <h4 class="h4-responsive grey-text">
                        There are currently no Courses in our Knowledge base.<br>
                        <a href="{{ route('admin.addCourse') }}" class="btn btn-primary btn-md capitalize"><span class="fa fa-plus"></span> Add Class</a>
                    </h4>
                </div>
            @else
                @foreach($params['courses'] as $course)
                    <div data-href="/admin/viewCourses/{{ $course->id }}" class="link col-md-5 col-xl-auto mx-auto card pad-0" style="margin-bottom:10px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <h1 class="bold h1-responsive no-margin">{{ number_format(count($course->allClasses)) }}</h1>
                                    <small>Classes</small>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <h1 class="bold h1-responsive no-margin">{{ number_format(count($course->subscription)) }}</h1>
                                    <small>Subscribers</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="lead semi-bold">{{ $course->course_title }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="pad-top-25">{{ $params['courses']->links() }}</div>
    </div>
@endsection