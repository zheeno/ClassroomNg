@extends('layouts.2columns_right')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Courses</title>
@endsection

@section('center')
    <div class="pad-top-50">
        <div class="container">
            <div class="row">
                <div class="col-12 pad-bot-25">
                    <h2 class="h2-responsive">Courses @if(!is_null($params['title'])) | {!! $params['title'] !!} @endif</h2>
                </div>
                <div class="col-lg-9 mx-auto" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
                    @include("components/searchBar")
                </div>
            </div>
            <div class="row pad-top-50">
                @if(count($params['courses']) == 0)
                    <div class="col-12 pad-top-100 center-align">
                        <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                        <h4 class="h4-responsive grey-text">
                            There are currently no Courses in our Knowledge base.<br>
                            Kindly check back some other time
                        </h4>
                    </div>
                @else
                    @foreach($params['courses'] as $course)
                        <div class="card pad-0 col-lg-10 mx-auto m-0 no-shadow transparent">
                            <div class="card-header transparent pad-0 no-border no-shadow">
                                <a href="/courses/{{ $course->course_title }}" class="h4-responsive btn-link" style="margin-bottom:5px">{{ $course->course_title }}</a>
                                <div>
                                    <small class="green-text" style="top:-10px;position:relative">{{ url('')}}/courses/{{ $course->course_title }}</small>
                                </div>
                            </div>
                            <div class="card-body pad-0">
                                <p style="top:-15px;position:relative" class="m-0 dark-grey-text">
                                    <?php
                                    if(strlen($course->description) >= 100){
                                        $pos=strpos($course->description, ' ', 100);
                                        echo nl2br(substr($course->description,0,$pos )); 
                                    }else{
                                        echo nl2br($course->description); 
                                    }
                                    ?>                                
                                </p>
                            <!-- <div style="margin-top:-15px">
                                <span class="badge"><span style="font-size:13px;color:#666">Classes&nbsp;&middot;&nbsp;{{ number_format(count($course->classes)) }}</span></span>
                                <span class="badge"><span style="font-size:13px;color:#666">Subscribers&nbsp;&middot;&nbsp;{{ number_format(count($course->subscription)) }}</span></span>
                            </div> -->
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-12">{{$params['courses']->links()}}</div>
            </div>
        </div>
    </div>
@endsection
