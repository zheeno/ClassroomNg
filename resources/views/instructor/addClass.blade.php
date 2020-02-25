@extends('layouts.3columns')

@section('title')
    <title>Instructor | Add Class</title>
@endsection

@section('center')
    <div class="container-fluid pad-bot-50">
        <div class="row pad-top-50">
            <div class="col-12">
                <h2 class="h2-responsive">Add Class</h2>
                <form method="POST" action="{{ route('classes.addClass') }}">
                    @csrf
                    <div class="md-form">
                        <label class="active">Course</label>
                        <select class="form-control no-border" name="course_id">
                            @foreach($params['courses'] as $course)
                                <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md-form">
                        <label>Class Topic</label>
                        <input type="hidden" id="class_id" name="class_id" value="{{ $params['class']->id }}" />
                        <input type="text" name="class_title" class="form-control" value="{{ $params['class']->class_title }}" required/>
                    </div>
                    <div class="md-form">
                        <label class="active">Article</label>
                        <textarea id="summernote" name="article" style="width:100%"></textarea>
                        <input type="hidden" id="hasImg" name="hasImages" value="false" />
                        <input type="hidden" id="numImg" name="numImages" value="0" />
                    </div>
                    <div class="alert alert-info">We recommend installing <strong><a href="https://chrome.google.com/webstore/detail/grammarly-for-chrome/kbfnbcaeplbcioakkpcpgfkobkghlhen?hl=en" target="_blank">Grammarly for Chrome</a></strong> on your browser to eliminate grammar errors</div>
                    <div class="attachments img-list row" data-count="0">
                        <a class="add-img-btn col-md-2 col-lg-3 card pad-0" style="margin:20px">
                            <div class="card-body center-align">
                                <span class="fa fa-plus-circle fa-2x"></span>
                                <h5 class="h5-responsive grey-text" style="margin-top:10px">Add Image</h5>
                            </div>
                        </a>
                    </div>
                    <div class="row">
                    <div class="col-md-8 mx-auto">
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
                    <div class="col-md-4 mx-auto center-align">
                        <button type="submit" class="btn btn-md btn-primary capitalize"><span class="fa fa-plus"></span>&nbsp;Add Class</button>
                        <button type="button" data-class-id="{{$params['class']->id}}" class="discard-class-btn btn btn-md btn-danger capitalize"><span class="fa fa-times-circle"></span>&nbsp;Discard Class</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection