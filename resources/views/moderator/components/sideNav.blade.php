<div class="row">
    <ul class="list-group col-12">
        <li data-href="{{ route('moderator.dashboard') }}" class="link btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize"><span class="fa fa-home"></span>&nbsp;Home&nbsp;<span class="fa fa-angle-right m-1 pull-right grey-text"></span></li>
        <li class="btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize @if(count(Auth::user()->assignedCourses) == 0) disabled @endif" data-toggle="collapse" data-target="#assignedCourses" ><span class="fa fa-list"></span>&nbsp;My Courses&nbsp;
        <span class="fa fa-angle-down m-1 pull-right grey-text"></span>
            @if(count(Auth::user()->assignedCourses) > 0)
                ({{number_format(count(Auth::user()->assignedCourses))}})
            @endif
        </li>
        <div id="assignedCourses" class="collapse @if(count(Auth::user()->assignedCourses) > 0) show @endif pad-0"  style="margin-bottom:0px">
            <ul class="list-group" style="background-color: #21212185;">
                @foreach(Auth::user()->assignedCourses as $assignedCoursesItem)    
                    <a href="/moderator/course/{{ $assignedCoursesItem->course->id }}" class="list-group-item transparent white-text waves-effect waves-light">
                        {{ $assignedCoursesItem->course->course_title }}
                        <span class="fa fa-angle-right m-1 pull-right grey-text"></span>
                    </a>
                @endforeach
            </ul>
        </div>
    </ul>
</div>