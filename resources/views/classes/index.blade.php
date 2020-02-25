@extends('layouts.3columns')

@section('title')
    <title>Class | {{ $params['class']->class_title }}</title>
@endsection


@section('center')
        <div class="col-12" style="text-align:right;margin:0px">
            <a href="/courses/{{ $params['class']->course->course_title }}" class="badge grey-text" style="font-size:13px;font-weight:400 !important;"><span class="fa fa-book grey-text"></span> <span class="grey-text">{{ $params['class']->course->course_title }}</span></a>
            <label class="badge" style="font-size:13px;font-weight:400 !important;"><span class="fa fa-clock-o grey-text"></span> <time class="capitalize grey-text timeago" datetime="{{ $params['class']->created_at }}" style="font-size:12px;"></time></label>
        </div>
        <div class="col-12" style="padding-left:15px">
            <div style="margin:0px">
                <span style="margin:0px"><a class="blue-text h2-responsive" href="{{ route('courses.index') }}">Courses / </a><a class="blue-text h2-responsive" href="/courses/{{ $params['class']->course->course_title }}">{{ $params['class']->course->course_title }} / </a><span class="h2-responsive">{{ $params['class']->class_title }}               
                    @if(Auth::check())    
                        @if((Auth::user()->id == $params['class']->instructor_id && Auth::user()->isInstructor()) || Auth::user()->isModerator() || Auth::user()->isAdmin())
                            <!-- check status -->
                            @if($params['class']->status == "PENDING")<span class="fa fa-clock-o orange-text" style="font-size:15px"></span>@endif
                            @if($params['class']->status == "REJECTED")<span class="fa fa-warning red-text" style="font-size:15px"></span>@endif
                            @if($params['class']->status == "APPROVED")<span class="fa fa-check-circle green-text" style="font-size:15px"></span>@endif
                        @endif
                    @endif
                    </span>
                </span>
            </div>
            <div style="margin:0px;margin-top: 0px;margin-left: -10px;">
            @if(Auth::check())
                @if( $params['class']->instructor_id == Auth::user()->id)
                    <a href="/classes/{{ $params['class']->id }}/editClass" class="class-edit-btn btn btn-sm btn-info btn-rounded" data-class-id="{{ $params['class']->id }}" style="padding: 8px;width: 30px;height: 30px;margin:0px"><span class="fa fa-edit white-text"></span></a>
                    <a data-class-id="{{$params['class']->id}}" class="discard-class-btn btn btn-sm btn-danger btn-rounded" data-class-id="{{ $params['class']->id }}" style="padding: 8px;width: 30px;height: 30px;margin:0px;"><span class="fa fa-trash white-text"></span></a>
                @endif
            @endif
                <a href="/instructors/{{ $params['class']->instructor->id }}" class="btn btn-primary btn-sm btn-rounded" style="@if(count($params['class']->instructor->myAvatar) > 0) background-image:url('{{$params['class']->instructor->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif margin:0px; padding: 8px;width: 30px;height: 30px;">@if(count($params['class']->instructor->myAvatar) == 0) {{substr($params['class']->instructor->name, 0, 1)}} @endif</a>
                <label class="capitalize black-text bold" style="font-size:16px;margin-left:5px">{{ $params['class']->instructor->name }}</label>
            </div>
        </div>
        <div class="container pad-top-50">
            <div class="row">
                <div class="col-12">
                {!! $params['class']->article !!}
                </div>
            </div>
            @if(count($params['class']->attachments) > 0)
                <div class="row attachments img-list" data-count="{{count($params['class']->attachments)}}">
                    @foreach($params['class']->attachments as $attachment)
                        <div id="selector_{{ $attachment->id }}" class="preview-img-btn col-md-2 col-lg-3 card pad-0" style="margin:20px;background-image:url('{{ $attachment->uri }}');background-size:cover;background-position:top;background-repeat:no-repeat">
                            <div class="card-body center-align" style="height:80px">
                                
                            </div>
                            <a data-uri="{{ $attachment->uri }}" data-caption="{{$attachment->caption}}" class="open-img card-footer bg-dark pad-0 m-0" style="padding:5px 10px 10px 10px !important">
                                <p class="white-text m-0">{{ $attachment->caption }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @if(Auth::check())
            <!-- review -->
            @if((Auth::user()->isModerator() && $params['isAssigned']) || Auth::user()->isAdmin() || Auth::user()->id == $params['class']->instructor_id)
                <hr />
                <div class="container">
                    <div class="row pad-top-25">
                        <div class="col-12">
                            <h3 class="h3-responsive">Reviews ({{ number_format(count($params['class']->reviewsWithoutAuthResponse)) }})</h3>
                            @if(session("revSuccess"))
                                <div class="alert alert-success">
                                    {{ session("revSuccess") }}
                                </div>
                            @endif
                            @if((Auth::user()->isModerator() && $params['isAssigned']) || Auth::user()->isAdmin())
                                <!-- review box -->
                                <div class="card white no-shadow pad-0">
                                    <form method="POST" action="@if(Auth::user()->isModerator()){{ route('moderator.addReview') }}@elseif(Auth::user()->isAdmin()){{ route('admin.addReview') }}@endif" class="card-body row pad-0">
                                        @csrf
                                        <div class="col-md-7">
                                            <input type="hidden" name="class_id" value="{{ $params['class']->id }}" />
                                            <input type="hidden" id="revStat" name="status" value="APPROVED" />
                                            <textarea id="revText" name="review" style="padding:10px;resize:none;width:100%;border-width:0px" placeholder="What do you think?"></textarea>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row pad-0">
                                                <div class="col-6 pad-0 no-margin no-radius">
                                                    <a data-state="false" data-value="REJECTED" data-type="rej" class="btn-rev-rej btn grey lighten-3 no-margin no-radius btn-sm btn-block capitalize"><span class="fa fa-times-circle"></span> Reject</a>
                                                </div>
                                                <div class="col-6 pad-0 no-margin no-radius">
                                                    <a data-state="true" data-value="APPROVED" data-type="app" class="btn-rev-app btn green darken-1 white-text no-margin no-radius btn-sm btn-block capitalize"><span class="fa fa-check-circle"></span> Approve</a>
                                                </div>
                                                <div class="col-12 pad-0 no-margin no-radius">
                                                    <button type="submit" class="btn btn-amber no-margin no-radius btn-sm btn-block capitalize"><span class="fa fa-paper-plane"></span> Send Review</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        @if(count($params['class']->reviews) == 0)
                            <div class="col-12 center-align grey lighten-4 pad-top-25 pad-bot-25">
                                <span class="fa fa-info-circle fa-2x"></span>
                                <h4 class="h4-responsive">No reviews have been made on this class</h4>
                            </div>
                        @else
                            @foreach($params['class']->reviews as $review)
                                @if(!is_null($review->moderator_id))
                                    <div class="card pad-0 col-12" style="margin-bottom:10px">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 center-align">
                                                    <a class="btn btn-primary btn-sm btn-rounded" style="@if(count($review->moderator->myAvatar) > 0) background-image:url('{{$review->moderator->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif padding: 8px;width: 30px;height: 30px;">@if(count($review->moderator->myAvatar) == 0) {{substr($review->moderator->name, 0, 1)}} @endif</a>
                                                   <label class="capitalize grey-text" style="font-size:14px;margin-left:-5px">{{ $review->moderator->name }}</label>
                                                    <br />
                                                    <small class="grey-text">{{ $review->created_at }}</small>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>{!! $review->review !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(!is_null($review->instructor_id))
                                    <div class="col-12 pad-0 card no-shadow transparent" style="margin-bottom:10px">
                                        <div class="card-body pad-0">
                                            <div class="pad-0 row">
                                                <div style="padding: 1px !important;border-radius: 30px;" class="pad-0 col-md-6 mx-auto center-align cyan lighten-1">
                                                    <span>{!! $review->review !!}</span><br>
                                                    <small style="color: #f5f5f5 !important">{{ $review->created_at }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        @endif

        <!-- comments -->
        <hr />
        <div class="container">
            <div class="row pad-top-25">
                <div class="col-12">
                    <h3 class="h3-responsive">Comments ({{ number_format(count($params['class']->comments)) }})</h3>
                    <!-- comment box -->
                    @Auth()
                        @if(Auth::user()->isStudent() || Auth::user()->isInstructor())
                            <div class="card white no-shadow pad-0">
                                <form method="POST" action="{{ route('classes.addComment') }}" class="card-body row pad-0">
                                    @csrf
                                    <div class="col-9">
                                        <input type="hidden" name="class_id" value="{{ $params['class']->id }}" />
                                        <textarea name="comment" style="padding:10px;resize:none;width:100%;border-width:0px" placeholder="What do you think?" required></textarea>
                                    </div>
                                    <div class="col-3 center-align" style="padding-top:10px">
                                        <button type="submit" class="btn btn-primary btn-md"><span class="fa fa-paper-plane"></span></button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="center-align grey lighten-4 pad-top-25 pad-bot-25">
                                <span class="fa fa-info-circle fa-2x"></span>
                                <h4 class="h4-responsive">You have to be logged in with a student or an instructor&apos;s account to add a comment</h4>                                
                            </div>
                        @endif
                    @else
                        <div class="center-align grey lighten-4 pad-top-25 pad-bot-25">
                            <span class="fa fa-info-circle fa-2x"></span>
                            <h4 class="h4-responsive">Sign In to make a comment</h4>
                            <a class="btn btn-primary btn-sm capitalize" href="{{ route('login') }}">Sign In</a>
                        </div>
                    @endauth
                    <hr />
                    @if(session("success"))
                        <div class="alert alert-success">
                            {{ session("success") }}
                        </div>
                    @endif
                    <!-- show comments -->
                    @if(count($params['class']->comments) == 0)
                        <div class="center-align grey lighten-4 pad-top-25 pad-bot-25">
                            <span class="fa fa-info-circle fa-2x"></span>
                            <h4 class="h4-responsive">No comments have been made on this class</h4>
                        </div>
                    @else
                        @foreach($params['class']->comments as $comment)
                            <div class="row pad-0" style="margin-bottom:8px;border-bottom:1px solid #e4e4e4">
                                <div class="col-12 transparent card pad-0 no-shadow">
                                    <div class="card-header no-border transparent pad-0">
                                        <div class="row pad-0">
                                            <div class="col-md-7" style="margin:0px;">
                                                <a class="btn btn-primary btn-sm btn-rounded" style="@if(count($comment->user->myAvatar) > 0) background-image:url('{{$comment->user->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat; @endif padding: 8px;width: 30px;height: 30px;">@if(count($comment->user->myAvatar) == 0) {{substr($comment->user->name, 0, 1)}} @endif</a>
                                                <label class="capitalize grey-text" style="font-size:14px;margin-left:-5px">{{ $comment->user->name }}</label>
                                            </div>
                                            <div class="col-md-5 right-align">
                                                <label class="badge no-shadow" style="font-size:13px;font-weight:400 !important;"><span class="fa fa-clock-o grey-text"></span> <time class="capitalize grey-text timeago" datetime="{{ $comment->created_at }}" style="font-size:12px;"></time></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body lead" style="padding:0px 10px;font-size: 1rem;">
                                        {!! $comment->comment !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
@endsection
