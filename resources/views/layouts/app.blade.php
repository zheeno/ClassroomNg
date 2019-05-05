<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
        <!-- Styles -->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('mdb/css/font-awesome.min.css') }}">
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('mdb/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="{{ asset('mdb/css/mdb.min.css') }}" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="{{ asset('mdb/css/style.css') }}" rel="stylesheet">
    </head>
<body>
       
    <!-- navigation bar -->
    @include('components/navigation')
    <section class="container-fluid" style="margin-top:66px;height: 100vh;">
        <div class="row h-100">
            <div class="col-md-6 p-0 h-100 m-0 overflow-y">
                @yield('content')
            </div>
            <div class="col-md-6 p-0 m-0">
                @yield('right')
            </div>
        </div>
    </section>
    
    <!-- footer -->
    @include('components/footer')
</body>
</html>
