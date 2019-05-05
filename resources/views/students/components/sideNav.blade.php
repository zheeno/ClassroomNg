<div class="row">
    <ul class="list-group col-12">
    <li data-href="{{ route('home') }}" class="link btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize"><span class="fa fa-dashboard"></span>&nbsp;Home&nbsp;<span class="fa fa-angle-right m-1 pull-right grey-text"></span></li>
        <!-- courses which student is subscribed to -->
        <li class="btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize @if(count(Auth::user()->courseList) == 0) disabled @endif" data-toggle="collapse" data-target="#stuCourseList" ><span class="fa fa-book"></span>&nbsp;My Courses&nbsp;
            @if(count(Auth::user()->courseList) > 0)
                &middot;&nbsp;{{number_format(count(Auth::user()->courseList))}}
            @endif
            <span class="fa fa-angle-down m-1 pull-right grey-text"></span>
        </li>
        <div id="stuCourseList" class="collapse pad-0"  style="margin-bottom:0px">
            <ul class="list-group" style="background-color: #21212185;">
                @foreach(Auth::user()->courseList as $courseListItem)    
                    <a href="/courses/{{ $courseListItem->course->course_title }}" class="list-group-item transparent white-text waves-effect waves-light">
                        {{ $courseListItem->course->course_title }}
                        <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
                    </a>
                @endforeach
            </ul>
        </div>
        <!-- instructors which student is subscribed to -->
        <li class="btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize @if(count(Auth::user()->instructorSubscription) == 0) disabled @endif" data-toggle="collapse" data-target="#myInstList" ><span class="fa fa-group"></span>&nbsp;Instructors&nbsp;
            @if(count(Auth::user()->instructorSubscription) > 0)
                &middot;&nbsp;{{number_format(count(Auth::user()->instructorSubscription))}}
            @endif
            <span class="fa fa-angle-down m-1 pull-right grey-text"></span>
        </li>
        <div id="myInstList" class="collapse pad-0" style="margin-bottom:0px">
            <ul class="list-group" style="background-color: #21212185;">
                @foreach(Auth::user()->instructorSubscription as $instructor)    
                    <a href="/instructors/{{ $instructor->instructor->id }}" class="list-group-item transparent white-text waves-effect waves-light">
                        {{ $instructor->instructor->name }}
                        <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
                    </a>
                @endforeach
            </ul>
        </div>
    </ul>
</div>