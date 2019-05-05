@extends('layouts.3columns')

@section('title')
    <title>Instructor | {{ $params['instructor']->name }}</title>
@endsection

@section('center')
    <div class="pad-top-25">
        <span><a href="{{ route('instructors') }}" class="h2-responsive btn-link">Instructors</a> <span class="h2-responsive">/ {{ $params['instructor']->name }}</span></span>
        <div class="container pad-0">
        <!-- profile -->
        <div class="row pad-0 pad-top-25 cyan darken-4" style="margin-top:75px">
            <div class="col-12 center-align p-3">
                <div class="medium-circle bg-dark footer" style="@if(count($params['instructor']->myAvatar) > 0) background-image:url('{{$params['instructor']->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif border:3px solid #FFF; margin-top:-75px">
                    <!-- profile pic -->
                </div>
                <h3 class="h3-responsive semi-bold white-text">{{ $params['instructor']->name }}</h3>
                <div style="margin-top:-12px">
                    @if($params['instructor']->high_deg != null)
                        <small class="note white-text">{{ $params['instructor']->high_deg }} @if($params['instructor']->inst_high_deg != null) ({{ $params['instructor']->inst_high_deg }}) @endif</small><br>
                    @endif
                    @if($params['instructor']->other_deg != null)
                        <small class="note white-text" style="top:-7px;position:relative">{{ $params['instructor']->other_deg }}</small><br>
                    @endif
                    @if($params['instructor']->first_deg != null)
                        <small class="note white-text" style="top:-14px;position:relative">{{ $params['instructor']->first_deg }}</small>
                    @endif
                </div>
            </div>
            <div class="col-12 grey lighten-2">
                <div class="row">
                    <div class="col-6 waves-effect waves-dark" style="padding: 10px 10px;text-align: center;font-weight: 400;border-right: 1px solid #bdbdbdab;">
                        <span>Classes&nbsp;&middot;&nbsp;{{ number_format($params['all_classes']) }}</span>
                    </div>
                    <div class="col-6 waves-effect waves-dark" style="padding: 10px 10px;text-align: center;font-weight: 400;">
                        <span>Followers&nbsp;&middot;&nbsp;<span class="followers-holder">{{ number_format($params['followers']) }}</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if($params['instructor']->bio !== null)
                    <p class="note lead">{!! $params['instructor']->bio !!}
                @endif
                @auth()
                    @if(Auth::user()->isStudent())
                        <div class="pad-bot-25 center-align w-100" style="margin:0px">
                            @if($params['following'])
                                <a data-instructor-id="{{ $params['instructor']->id }}" data-sending="false" data-state="1" class="instructor-sub-tog-btn btn-rounded btn btn-md btn-danger capitalize" style="margin-left:-2px"><span class="fa fa-minus-circle"></span> <span class="text">Unfollow</span></a>
                            @else
                                <a data-instructor-id="{{ $params['instructor']->id }}" data-sending="false" data-state="0" class="instructor-sub-tog-btn btn-rounded btn btn-md btn-primary capitalize" style="margin-left:-2px"><span class="fa fa-plus-circle"></span> <span class="text">Follow</span></a>
                            @endif
                            <div id="temp" class="hidden" ></div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        <!-- feeds -->
            <div class="row pad-top-25">
                 @if(count($params['classes']) == 0)
                    <div class="col-12 pad-top-100 center-align">
                        <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                        <h4 class="h4-responsive grey-text">
                            There are currently no classes to be displayed.
                        </h4>
                    </div>
                @else
                    @foreach($params['classes'] as $class)
                        @include('components/feed')
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-12 pad-top-25">
                    {{ $params['classes']->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection