<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ClassroomNg</title>

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
    <!-- Header -->
        @include('components/navigation')
    <!-- header ends her -->
    <body>
        <section>
        <div class="container-fluid intro bg-img bg-girl-in-library">
        <div class="row mask-overlay">
            <div class="col-md-11 col-lg-10 mx-auto">
            <div class="pad-top-25">
                <div class="container pad-top-50">
                    <div class="row pad-top-50">
                        <div class="col-12 center-align pad-bot-50">
                            <div class="bg-white medium-circle bg-img bg-ed-logo">
                        </div>
                    </div>
                    <div class="col-lg-9 mx-auto" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
                        @include("components/searchBarClass")
                    </div>
                </div>
                <div class="col-lg-10 mx-auto center-align pad-top-25">
                    <h5 class="h5-responsive white-text" style="font-size: 150%">
                    ClassroomNg is a global study place. 
                    A place where students are introduced to
                    a wide array of subject areas helping them
                    achieve their study goals by learning from an extensive library of 
                    courses taught by instructors who are well grounded in their fields of study.</h5>
                </div>
                <div class="col-12 center-align pad-bot-50">
                    <a class="btn no-radius btn-outline-white capitalize" href="./">Get Educated</a>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    @include('components/footer')
    </body>
</html>
