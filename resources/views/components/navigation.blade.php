<nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar bg-dark">
    <div class="container">
        <!-- Navbar brand -->
        <!-- <a class="navbar-brand" href="/">ClassroomNg</a> -->
        <img src="{{ asset('mdb/img/logo.png')}}" class="img-responsive" style="width:200px"/>
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
            <!-- Links -->
            <ul class="navbar-nav mr-auto smooth-scroll">
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="{{ route('courses.index') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="{{ route('instructors') }}">Instructors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="{{ route('educate') }}">Educate Me</a>
                </li>
            </ul>
            <!-- Links -->

            <!-- Social Icon  -->
            <ul class="navbar-nav nav-flex-icons">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" 
                            href="/home"
                            >Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right pad-0" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('me.profile') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="{{ route('login') }}">Sign In</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-light" href="{{ route('register') }}">Sign Up</a>
                            </li> 
                        @endif
                    @endauth
                @endif
                <li class="nav-item">
                    <!-- Language Translate -->
                    <div id="google_translate_element"></div>	  
                    <!--  End Translate Tool -->
                </li>
            </ul>
        </div>
        <!-- Collapsible content -->
    </div>
</nav>
