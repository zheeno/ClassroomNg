@extends('layouts.3columns')

@section('title')
    <title>Edit Class | {{ $params['class']->class_title }}</title>
@endsection

@section('center')
    <div class="container-fluid pad-bot-50">
        <div class="row pad-top-50">
            <div class="col-12">
                <h2 class="h2-responsive">Edit Class / <span class="uppercase">{{ $params['class']->class_title }}</span></h2>
                <form method="POST" action="{{ route('classes.updateClass') }}">
                    @csrf
                    <div class="md-form">
                        <label class="active">Course</label>
                        <input type="hidden" id="class_id" name="class_id" value="{{$params['class']->id }}" />
                        <select class="form-control no-border" name="course_id">
                            @foreach($params['courses'] as $course)
                                <option value="{{ $course->id }}" <?php if($params['class']->course_id == $course->id){ echo "selected"; }?>>{{ $course->course_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md-form">
                        <label class="active">Class Topic</label>
                        <input type="text" name="class_title" class="form-control" value="{{ $params['class']->class_title }}" required/>
                    </div>
                    <div class="md-form">
                        <label class="active">Article</label>
                        <textarea id="summernote" name="article" style="width:100%">{{ $params['class']->article }}</textarea>
                    </div>
                    <div class="alert alert-info">We recommend installing <strong><a href="https://chrome.google.com/webstore/detail/grammarly-for-chrome/kbfnbcaeplbcioakkpcpgfkobkghlhen?hl=en" target="_blank">Grammarly for Chrome</a></strong> on your browser to eliminate grammar errors</div>
                    <div class="row attachments img-list" data-count="{{count($params['class']->attachments)}}">
                        <a class="add-img-btn col-md-2 col-lg-3 card pad-0" style="margin:20px">
                            <div class="card-body center-align">
                                <span class="fa fa-plus-circle fa-2x"></span>
                                <h5 class="h5-responsive grey-text" style="margin-top:10px">Add Image</h5>
                            </div>
                        </a>
                        @if(count($params['class']->attachments) > 0)
                            @foreach($params['class']->attachments as $attachment)
                                <div id="selector_{{ $attachment->id }}" class="preview-img-btn col-md-2 col-lg-3 card pad-0" style="margin:20px;background-image:url('{{ $attachment->uri }}');background-size:cover;background-position:top;background-repeat:no-repeat">
                                    <div class="card-body center-align" style="height:80px">
                                        @if(Auth::check())
                                            @if( $params['class']->instructor_id == Auth::user()->id)
                                                <a onClick="removeImgFromImgList({{ $attachment->id}})" class="btn pad-0 btn-circle-sm bg-dark" style="right:-15px;top:-15px;position:absolute">
                                                    <span class="fa fa-times white-text" style="font-size: 20px;margin: 4px;"></span>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                    <a data-uri="{{ $attachment->uri }}" data-caption="{{$attachment->caption}}" class="open-img card-footer bg-dark pad-0 m-0" style="padding:5px 10px 10px 10px !important">
                                        <p class="white-text m-0">{{ $attachment->caption }}</p>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                    <div class="col-8">
                        <div class="alert alert-info" style="text-align:justify">
                            <small><span class="fa fa-info-circle"></span>
                            All articles are sent to our experts to be reviewed;
                            this helps us scrutinize the quality of articles which are put up on our knowledge base.
                            Kindly note that all articles with inaccurate facts
                            would not be approved; You would be informed accordingly
                            on any changes that are required to be made on your articles,
                            if need be, for them to be approved.</small>
                        </div>
                    </div>
                    <div class="col-md-4 center-align">
                        <button type="submit" class="btn btn-md btn-primary capitalize"><span class="fa fa-paper-plane"></span>&nbsp;Save &amp; Send for Review</button>
                        <button type="button" data-class-id="{{$params['class']->id}}" class="discard-class-btn btn btn-md btn-danger capitalize"><span class="fa fa-times-circle"></span>&nbsp;Discard Class</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection