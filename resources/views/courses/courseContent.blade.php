@extends('layouts.3columns')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | {{ $params['course']->course_title }}</title>
@endsection

@section('center')
        <div class="container">
            <div class="row">
                <div class="col-12 pad-bot-25">
                    <div class="capitalize">
                        <a class="h2-responsive" href="{{ route('courses.index') }}">Courses</a> 
                        <a data-toggle="dropdown" class="h2-responsive">/ 
                            {{ $params['course']->course_title }}
                            ({{ number_format(count($params['course']->classes)) }})
                        </a>
                        <a class="btn btn-sm no-shadow pad-0" style="margin-top:-5px" data-toggle="dropdown"><span class="fa fa-caret-down"></span></a>
                        <div class="dropdown-menu pad-0">
                            <ul class="list-group pad-0">
                                @foreach($params['courses'] as $course)
                                    <a class="list-group-item @if($course->id == $params['course']->id) disabled @endif" href="/courses/{{$course->course_title}}">
                                        {{$course->course_title}}
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-11">
                    @if($params['course']->description !== null)
                        <p class="note lead">{!! $params['course']->description !!}
                    @endif
                   @auth()
                        @if(Auth::user()->isStudent())
                            <div class="pad-bot-25 center-align" style="margin:0px">
                                @if($params['subscribed'])
                                    <a data-course-id="{{ $params['course']->id }}" data-sending="false" data-state="1" class="course-sub-tog-btn btn btn-rounded btn-md btn-danger capitalize" style="margin-left:-2px"><span class="fa fa-bell-slash"></span> <span class="text">Unsubscribe</span></a>
                                @else
                                    <a data-course-id="{{ $params['course']->id }}" data-sending="false" data-state="0" class="course-sub-tog-btn btn btn-rounded btn-md btn-primary capitalize" style="margin-left:-2px"><span class="fa fa-bell"></span> <span class="text">Subscribe</span></a>
                                @endif
                                <div id="temp" class="hidden" ></div>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="col-lg-9 mx-auto" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
                    @include("components/searchBarClass")
                </div>
            </div>
            <div class="row pad-top-50">
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
                <div class="col-12">
                    {{ $params['classes']->links() }}
                </div>
            </div>
        </div>
@endsection
