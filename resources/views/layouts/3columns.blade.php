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
        <div class="row pad-top-25 mx-h-100-res no-overflow-y">
            <div class="max-h-inherit-res m-0 overflow-y col-md-3 col-lg-2 pad-top-50 mx-auto pad-0 bg-img bg-girl-studying">
                @if(Auth::check())
                    <!-- profile photo -->
                    <div class="row pad-top-50 @if(Auth::user()->isStudent()) blue @elseif(Auth::user()->isInstructor()) cyan darken-4 @elseif(Auth::user()->isModerator()) purple darken-4 @elseif(Auth::user()->isAdmin()) amber darken-1 @endif" style="margin-top: -10px;">
                        <div class="col-12 center-align pad-bot-25">
                            <div data-href="/profile" class="link medium-circle bg-dark @if(count(Auth::user()->myAvatar) == 0) footer @endif" style="@if(count(Auth::user()->myAvatar) > 0) background-image:url('{{Auth::user()->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif border:3px solid #FFF !important;@if(!is_null(Auth::user()->profilePic)) background-image:url({{asset('')}}); @endif">
                                <!-- profile pic -->
                                @if(count(Auth::user()->myAvatar) == 0)
                                    <span class="fa-4x white-text m-2">{{substr(Auth::user()->name, 0, 1)}}</span>
                                @endif
                            </div>
                            <!-- user's name -->
                            <span class="h4-responsive semi-bold white-text capitalize">{{ Auth::user()->name }}</span>
                            <h5 class="h5-responsive bold white-text capitalize">
                                @if(Auth::user()->isStudent())
                                    Student
                                @elseif(Auth::user()->isInstructor())
                                    Instructor
                                @elseif(Auth::user()->isModerator())
                                    Moderator
                                @elseif(Auth::user()->isAdmin())
                                    Administrator
                                @endif
                            </h5>
                        </div>
                    </div>
                    @if(Auth::user()->isStudent())
                        @include('students/components/sideNav')
                    @elseif(Auth::user()->isInstructor())
                        @include('instructor/components/sideNav')
                    @elseif(Auth::user()->isModerator())
                        @include('moderator/components/sideNav')
                    @elseif(Auth::user()->isAdmin())
                        @include('admin/components/sideNav')
                    @endif
                @endif
                @yield('left')
            </div>
            <div class="max-h-inherit-res m-0 overflow-y col-md-6 col-lg-8 pad-top-50 pad-bot-50">
                @yield('center')
            </div>
            <div class="max-h-inherit-res m-0 overflow-y col-md-3 col-lg-2 pad-0 pad-top-50 grey lighten-3">
                @yield('right')
            </div>
        </div>
    </section>
    <!-- modal -->
    @include('components/modal')
            <!-- footer -->
            @include('components/footer')
</body>
</html>
