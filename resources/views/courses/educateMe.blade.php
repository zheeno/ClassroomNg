@extends('layouts.3columns')

@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Educate Me</title>
@endsection

@section('center')
    <div class="pad-top-50">
        <div class="container">
            <div class="row">
                <div class="col-12 pad-bot-25">
                    <div class="capitalize">
                        <span class="h2-responsive">Educate Me @if(!is_null($params['title']))| {!! $params['title'] !!} @endif</span> 
                    </div>
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
                            We could not find any data in our Knowledge base.<br>
                        </h4>
                    </div>
                @else
                
                    @foreach($params['classes'] as $class)
                        @include('components/feed')
                    @endforeach
                @endif
            </div>
            <div class="row pad-top-25">
                {{ $params['classes']->links() }}
            </div>
        </div>
    </div>
@endsection
