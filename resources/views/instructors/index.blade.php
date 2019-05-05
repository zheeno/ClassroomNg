@extends('layouts.3columns')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Instructors</title>
@endsection

@section('center')
    <div class="pad-top-50">
        <div class="container">
            <div class="row">
                <div class="col-12 pad-bot-25">
                    <h2 class="h2-responsive">Instructors @if(!is_null($params['title'])) | {!! $params['title'] !!} @endif</h2>
                </div>
                <div class="col-lg-9 mx-auto" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
                    <form class="row bg-white" action="/search/instructors" method="GET">
                        @csrf
                        <div class="col-md-8" style="padding:0px;padding-top:10px;">
                            <input name="q" type="text" class="form-control no-border no-radius" placeholder="Search Instructors" required/>
                        </div>
                        <div class="col-md-4 center-align" style="padding:0px;padding-bottom:10px">
                            <button class="btn btn-primary btn-md capitalize no-radius" style="top:7px;position:relative" type="submit"><span class="fa fa-search"></span> Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row pad-top-50">
                @if(count($params['instructors']) == 0)
                    <div class="col-12 pad-top-100 center-align">
                        <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                        <h4 class="h4-responsive grey-text">
                            There are currently no Instructors.<br>
                            Kindly check back some other time
                        </h4>
                    </div>
                @else
                    @foreach($params['instructors'] as $instructor)
                        <div class="col-md-5 col-lg-5 m-3 mx-auto card pad-0">
                            <div class="card-header transparent pad-0 no-border" style="z-index:1">
                                <div data-href="/instructors/{{$instructor->id}}" class="link medium-circle bg-dark footer" style="@if(count($instructor->myAvatar) > 0) background-image:url('{{$instructor->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat;background-position:top; @endif border:3px solid #FFF;text-align:center">
                                    <!-- profile pic -->
                                        @if(count($instructor->myAvatar) == 0)<span class="fa-4x white-text m-2">{{substr($instructor->name, 0, 1)}}</span>@endif

                                </div>
                            </div>
                            <div class="card-body pad-0 cyan darken-4" style="z-index:0;margin-top: -45px;padding-top: 50px !important;padding: 50px 10px 0px !important;margin-bottom: 0px !important;text-align: center;">
                                <h3 class="m-1 h3-responsive semi-bold white-text">{{ $instructor->name }}</h3>
                                <div class="p-3">
                                    @if($instructor->high_deg != null)
                                        <small class="note white-text">{{ $instructor->high_deg }} @if($instructor->inst_high_deg != null) ({{ $instructor->inst_high_deg }}) @endif</small><br>
                                    @endif
                                    @if($instructor->other_deg != null)
                                        <small class="note white-text">{{ $instructor->other_deg }}</small><br>
                                    @endif
                                    @if($instructor->first_deg != null)
                                        <small class="note white-text">{{ $instructor->first_deg }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-12">{{$params['instructors']->links()}}</div>
            </div>
        </div>
    </div>
@endsection
