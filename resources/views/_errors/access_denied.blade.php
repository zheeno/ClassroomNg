@extends('layouts.app')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} - Access Restricted</title>
@endsection
@section('content')
    <div class="container-fluid pad-top-50 pad-bot-50 center-align">
        <div class="row flex-center">
            <div class="col-12 center-align">
                <h1 class="grey-text h1-responsive" style="font-size:800%;font-weight:800">Access Denied</h1>
                <h5 class="h5-responsive grey-text">You do not have the required permission to access this section</h5>
            </div>
        </div>
    </div>
@endsection
