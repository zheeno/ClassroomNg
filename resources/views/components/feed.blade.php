<div id="class_{{ $class->id }}" class="col-md-12 col-lg-10 col-xl-5 mx-auto pad-0 card" style="margin-bottom:10px">
    <div class="card-header waves-effect waves-light bg-dark footer no-border no-shadow">
        <div class="row pad-0">
            <div data-href="/classes/{{ $class->id }}" class="link col-12">
                <h4 class="h4-responsive white-text semi-bold uppercase" style="margin-bottom:0px">
                    {{ $class->class_title }}
                    @if(Auth::check())
                        @if((Auth::user()->id == $class->instructor_id && Auth::user()->isInstructor()) || Auth::user()->isModerator() || Auth::user()->isAdmin())
                            <!-- check status -->
                            @if($class->status == "DRAFT")<span class="fa fa-newspaper-o cyan-text pull-right m-1"></span>@endif
                            @if($class->status == "PENDING")<span class="fa fa-clock-o orange-text pull-right m-1"></span>@endif
                            @if($class->status == "REJECTED")<span class="fa fa-warning red-text pull-right m-1"></span>@endif
                            @if($class->status == "APPROVED")<span class="fa fa-check-circle green-text pull-right m-1"></span>@endif
                        @endif
                    @endif
                </h4>
                <div style="margin-top: -5px;">
                    @if(!is_null($class->course))
                        <label class="capitalize badge grey-text grey darken-5" style="font-size:13px;font-weight:400 !important;"><span class="fa fa-book grey-text"></span> <span class="grey-text">{{ $class->course->course_title }}</span></label>
                    @endif
                    <label class="badge grey darken-5" style="font-size:13px;font-weight:400 !important;"><span class="fa fa-clock-o grey-text"></span> <time class="capitalize grey-text timeago" datetime="{{ $class->created_at }}" style="font-size:12px;"></time></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding-bottom:5px">
        <p class="dark-grey-text" style="margin:0px">
            <?php
            $article = strip_tags($class->article);
            if(strlen($article) >= 200){
                $pos=strpos($article, ' ', 200);
                echo nl2br(substr($article,0,$pos )); 
            }else{
                echo nl2br($article);
            }
            ?>                                
        </p>
    </div>
        <div class="card-footer pad-0 no-border transparent">
            <a href="/instructors/{{ $class->instructor->id }}" class="btn btn-primary btn-sm btn-rounded" style="@if(count($class->instructor->myAvatar) > 0) background-image:url('{{$class->instructor->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif padding: 8px;width: 30px;height: 30px;">@if(count($class->instructor->myAvatar) == 0) {{substr($class->instructor->name, 0, 1)}} @endif</a>
            <label class="capitalize grey-text" style="font-size:14px;margin-left:-5px">{{ $class->instructor->name }}</label>
            @if(Auth::check())
                @if( $class->instructor_id == Auth::user()->id)
                    <a href="/classes/{{ $class->id }}/editClass" class="class-edit-btn btn btn-sm btn-info btn-rounded" data-class-id="{{ $class->id }}" style="padding: 8px;width: 30px;height: 30px;margin:0px"><span class="fa fa-edit white-text"></span></a>
                    <a class="class-delete-btn btn btn-sm btn-danger btn-rounded" data-class-id="{{ $class->id }}" style="padding: 8px;width: 30px;height: 30px;margin:0px"><span class="fa fa-trash white-text"></span></a>
                @endif
            @endif
        </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-6 center-align">
                <span class="fa fa-comments"style="color:#666"></span>
                <span style="color:#666">Comments&nbsp;&middot;&nbsp;{{ number_format(count($class->comments)) }}</span>
            </div>
            <div class="col-6 center-align">
                <span class="fa fa-group" style="color:#666"></span>
                <span style="color:#666">Students&nbsp;&middot;&nbsp;{{ number_format(count($class->students)) }}</span>
            </div>
        </div>
    </div>
</div>