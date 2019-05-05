@extends('layouts.3columns')

@section('title')
    <title>Dashboard | {{ Auth::user()->name }}</title>
@endsection

@section('center')
    <div class="pad-top-25">
        <h1 class="h1-responsive">Home</h1>
        <div class="container pad-top-50">
            <div class="col-lg-9 mx-auto" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
                @include("components/searchBarClass")
            </div>
        </div>
        <!-- feeds -->
        <div class="container">
            <div class="row pad-top-25">
                @if(count($params['classes']) == 0)
                        <div class="col-12 pad-top-100 center-align">
                            <span class="fa fa-info-circle grey-text" style="font-size:150px"></span>
                            <h4 class="h4-responsive grey-text">
                                There are currently no classes to be displayed.<br>
                                We suggest you subscribe to more Courses and 
                                follow your favorite Instructors to stay up-to-date.
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

