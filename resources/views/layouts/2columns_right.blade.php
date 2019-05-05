<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('title')

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

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
        <!-- main -->
        <section class="container-fluid">
            <div class="row pad-top-25 max-h-100-res no-overflow-y">
                <div class="max-h-inherit-res overflow-y col-md-9 col-lg-10 pad-top-50 pad-bot-50 bg-green">
                    @yield('center')
                </div>
                <div class="max-h-inherit-res overflow-y col-md-3 col-lg-2 pad-top-50 grey lighten-3">
                    @yield('right')
                </div>
            </div>
        </section>
        <!-- footer -->
        @include('components/footer')
</body>
</html>
