@extends('layouts.3columns')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Moderator</title>
@endsection

@section('center')
    <div class="pad-top-50">
        <div class="container">
            <div class="row">
                <div class="col-12 pad-bot-25">
                    <h2 class="h2-responsive">Moderator</h2>
                </div>
                <div class="col-lg-9 mx-auto" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
                    @include("components/searchBar")
                </div>
            </div>
            <div class="row pad-top-50">
                @if(count($params['assignedCourses']) == 0)
                    <div class="col-12 pad-top-100 center-align">
                        <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                        <h4 class="h4-responsive grey-text">
                            You have not been assigned to act as a moderator over any of our courses.<br>
                            Kindly check back some other time
                        </h4>
                    </div>
                @else
                    @foreach($params['assignedCourses'] as $assignedCourse)
                        <div class="col-md-4 col-lg-5 mx-auto card pad-0">
                            <div class="card-header">
                                <h4 class="h4-responsive">{{ $assignedCourse->course->course_title }} ({{ number_format(count($assignedCourse->course->allClasses)) }})</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="active orange-text">Pending</label>
                                        <h2 class="h2-responsive orange-text">{{ number_format(count($assignedCourse->course->pendingClasses)) }}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="active red-text">Rejected</label>
                                        <h2 class="h2-responsive red-text">{{ number_format(count($assignedCourse->course->rejectedClasses)) }}
                                    </div>
                                    <div class="col-md-12">
                                        <label class="active green-text">Approved</label>
                                        <h2 class="h2-responsive green-text">{{ number_format(count($assignedCourse->course->classes)) }}
                                    </div>
                                </div>
                            </div>
                            <div class="pad-0 card-footer right-align">
                                <a class="btn btn-md btn-primary capitalize" href="/moderator/course/{{ $assignedCourse->course_id }}">Review</a>
                            </div>
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-12">
                            {{ $params['assignedCourses']->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
