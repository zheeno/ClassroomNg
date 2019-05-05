@extends('layouts.3columns')

@section('title')
    <title>Review Course | {{ $params['course']->course_title }}</title>
@endsection

@section('center')
    <div class="pad-top-50">
        <div class="container">
            <div class="row">
            <div class="col-12 pad-bot-25">
                    <div class="capitalize">
                        <a class="h2-responsive" href="{{ route('moderator.dashboard') }}">Courses</a> 
                        <a data-toggle="dropdown" class="h2-responsive">/ 
                            {{ $params['course']->course_title }}
                        </a>
                        <a class="btn btn-sm no-shadow pad-0" style="margin-top:-5px" data-toggle="dropdown"><span class="fa fa-caret-down"></span></a>
                        <div class="dropdown-menu pad-0">
                            <ul class="list-group pad-0">
                                @foreach($params['assignedTo'] as $assignedCourse)
                                    <a class="list-group-item @if($assignedCourse->course->id == $params['course']->id) disabled @endif" href="/moderator/course/{{$assignedCourse->course->id}}">
                                        {{$assignedCourse->course->course_title}}
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pad-top-50">
                @if(count($params['inReview']) == 0)
                    <div class="col-12 pad-top-100 center-align">
                        <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                        <h4 class="h4-responsive grey-text">
                            There are no classes to be reviewed in this course at the moment.<br />
                            Please check back some other time.
                        </h4>
                    </div>
                @else
                    @foreach($params['inReview'] as $class)
                        @include('components/feed')
                    @endforeach
                    <div class="row">
                        <div class="col-12">
                            {{ $params['inReview']->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
