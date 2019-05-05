@extends('layouts.app')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} - 404 Not Found</title>
@endsection
@section('content')
            <div class="container-fluid pad-top-50 pad-bot-50 center-align">
               <div class="row flex-center">
                    <div class="col-12">
                        <h1 class="grey-text h1-responsive" style="font-size:1000%;font-weight:800">404</h1>
                        <h5 class="h5-responsive grey-text">The content which you attempted to access could not be located on our servers</h5>
                    </div>
               </div>
        </div>
@endsection
