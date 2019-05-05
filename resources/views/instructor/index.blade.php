@extends('layouts.3columns')

@section('title')
    <title>Instructor | {{ Auth::user()->name }}</title>
@endsection

@section('center')
    <div class="container pad-0">
        <!-- profile -->
        <div class="row pad-0 pad-top-25 cyan darken-4" style="margin-top:75px">
            <div class="col-12 center-align p-3">
                <div class="medium-circle bg-dark footer" style="@if(count(Auth::user()->myAvatar) > 0) background-image:url('{{Auth::user()->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat;background-position:top; @endif border:3px solid #FFF; margin-top:-75px">
                    <!-- profile pic -->
                </div>
                <h3 class="h3-responsive semi-bold white-text">{{ Auth::user()->name }}</h3>
                <div style="margin-top:-12px">
                    @if(Auth::user()->high_deg != null)
                        <small class="note white-text">{{ Auth::user()->high_deg }} @if(Auth::user()->inst_high_deg != null) ({{ Auth::user()->inst_high_deg }}) @endif</small><br>
                    @endif
                    @if(Auth::user()->other_deg != null)
                        <small class="note white-text" style="top:-7px;position:relative">{{ Auth::user()->other_deg }}</small><br>
                    @endif
                    @if(Auth::user()->first_deg != null)
                        <small class="note white-text" style="top:-14px;position:relative">{{ Auth::user()->first_deg }}</small>
                    @endif
                </div>
            </div>
            <div class="col-12 grey lighten-2">
                <div class="row">
                    <div class="col-6 waves-effect waves-dark" style="padding: 10px 10px;text-align: center;font-weight: 400;border-right: 1px solid #bdbdbdab;">
                        <span>Classes&nbsp;&middot;&nbsp;<span class="classes-holder">{{ number_format($params['all_classes']) }}</span></span>
                    </div>
                    <div class="col-6 waves-effect waves-dark" style="padding: 10px 10px;text-align: center;font-weight: 400;">
                        <span>Followers&nbsp;&middot;&nbsp;<span class="followers-holder">{{ number_format($params['followers']) }}</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(Auth::user()->bio !== null)
                    <p class="note lead">{!! Auth::user()->bio !!}</p>
                @endif
            </div>
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">{!! session('success') !!}</div>
                @endif
            </div>
        </div>
        <!-- feeds -->
        
            @if(count($params['classes']) == 0)
                <div class="row pad-top-25">
                    <div class="col-12 pad-top-100 center-align">
                        <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                        <h4 class="h4-responsive grey-text">
                            There are currently no classes to be displayed.
                        </h4>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($params['classes'] as $class)
                        @include('components/feed')
                    @endforeach
                </div>
            @endif
        <div class="row">
            <div class="col-12 pad-top-25">
                {{ $params['classes']->links() }}
            </div>
        </div>
    </div>
@endsection