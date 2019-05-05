@extends('layouts.3columns')

@section('title')
    <title>Profile | {{ Auth::user()->name }}</title>
@endsection

@section('center')
    <div class="container pad-0">
        <!-- profile -->
        <div class="row pad-0 pad-top-25 @if(Auth::user()->isStudent()) blue @elseif(Auth::user()->isInstructor()) cyan darken-4 @elseif(Auth::user()->isModerator()) purple darken-4 @elseif(Auth::user()->isAdmin()) amber darken-1 @endif" style="margin-top:75px">
            <div class="col-12 center-align p-3">
                <div class="medium-circle bg-dark footer no-overflow" style="@if(count(Auth::user()->myAvatar) > 0) background-image:url('{{Auth::user()->myAvatar[0]->filename}}');background-size: cover; background-repeat:no-repeat;background-position:top @endif border:3px solid #FFF; margin-top:-75px">
                    <!-- profile pic -->
                    <span class="fa-4x white-text m-2" style="@if(count(Auth::user()->myAvatar) > 0) opacity: 0 @endif">{{substr(Auth::user()->name, 0, 1)}}</span>
                    <div class="medium-circle chg-ava no-overflow">
                        <button class="btn black" style="bottom:-40px;left:-5px;position:relative"><span class="fa fa-camera"></span></button>
                    </div>
                </div>
                <h3 class="h3-responsive semi-bold white-text">{{ Auth::user()->name }}</h3>
                <div style="margin-top:-12px">
                    @if(Auth::user()->high_deg != null)
                        <small class="note white-text">{{ Auth::user()->high_deg }} @if(Auth::user()->inst_high_deg != null) ({{ Auth::user()->inst_high_deg }}) @endif</small><br>
                    @endif
                    @if(Auth::user()->other_deg != null)
                        <small class="note white-text" style="top:-7px;position:relative">{{ Auth::user()->other_deg }}</small><br>
                    @endif
                    @if(Auth::user()->first_deg != null)
                        <small class="note white-text" style="top:-14px;position:relative">{{ Auth::user()->first_deg }}</small>
                    @endif
                </div>
            </div>
                @if(Auth::user()->isStudent())
                    <!--  -->
                @elseif(Auth::user()->isInstructor())
                    <div class="col-12 grey lighten-2">
                        <div class="row">
                            <div class="col-6 waves-effect waves-dark" style="padding: 10px 10px;text-align: center;font-weight: 400;border-right: 1px solid #bdbdbdab;">
                                <span>Classes&nbsp;&middot;&nbsp;<span class="classes-holder">{{ number_format(count(Auth::user()->myClasses)) }}</span></span>
                            </div>
                            <div class="col-6 waves-effect waves-dark" style="padding: 10px 10px;text-align: center;font-weight: 400;">
                                <span>Followers&nbsp;&middot;&nbsp;<span class="followers-holder">{{ number_format(count(Auth::user()->myFollowers)) }}</span></span>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->isModerator())
                    <!--  -->
                @elseif(Auth::user()->isAdmin())
                    <!--  -->
                @endif
        </div>
        <!-- {!! Form::open(array('route' => 'upload.avatar','enctype' => 'multipart/form-data')) !!}
            @csrf
            {!! Form::file('image', array('class' => 'image')) !!}
            <button type="submit" class="btn btn-md btn-primary capitalize">Upload</button>

        {!! Form::close() !!} -->
        <div class="row">
            @if(session('success'))
                <div class="col-md-10 mx-auto alert alert-success">{{ session('success')}}</div>
            @endif
            @if (count($errors) > 0)
                <div class="col-md-10 mx-auto alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('update.profile') }}" class="col-12 p-md-4 p-lg-5">
                @csrf
                <div class="row">
                    <div class="col-md 5 mx-auto md-form">
                        <label class="active">Full Name</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required/>
                    </div>
                    <div class="col-md 5 mx-auto md-form">
                        <label class="active">Account Type</label>
                        <input type="text" class="form-control disabled" disabled value="@if(Auth::user()->isStudent()) Student @elseif(Auth::user()->isInstructor()) Instructor @elseif(Auth::user()->isModerator()) Moderator @elseif(Auth::user()->isAdmin()) Administrator @endif" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md 5 mx-auto md-form">
                        <label class="active">First Degree &amp; Instituition</label>
                        <input type="text" class="form-control" name="first_deg" value="{{ Auth::user()->first_deg }}" required/>
                    </div>
                    <div class="col-md 5 mx-auto md-form">
                        <label class="active">Highest Degree Attained</label>
                        <input type="text" class="form-control" name="high_deg" value="{{ Auth::user()->high_deg }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md 11 mx-auto md-form">
                        <label class="active">Instituition of Highest Degree</label>
                        <input type="text" class="form-control" name="inst_high_deg" value="{{ Auth::user()->inst_high_deg }}" />
                    </div>
                    <div class="col-md 11 mx-auto md-form">
                        <label class="active">Other Degrees Attained</label>
                        <input type="text" class="form-control" name="other_deg" value="{{ Auth::user()->other_deg }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mx-auto md-form">
                        <label class="active">We&apos;d love to know more about you</label>
                        <textarea class="md-textarea w-100" name="bio" >{!! Auth::user()->bio !!}</textarea>
                    </div>
                    <div class="col-12 center-align mx-auto md-form">
                        <button type="submit" class="btn btn-primary btn-md capitalize">Save Changes</button>
                        <button type="button" class="btn chg-pwd grey lighten-2 btn-md capitalize">Change Password</button>
                    </div>
                </div>
            </form>
            <!--  -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-bottom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title w-100">
                            Change Avatar
                        </h4>
                        <a class="btn btn-sm transparent no-shadow white-text" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text fa fa-angle-down fa-2x"></span>
                        </a>
                    </div>
                    <div class="modal-body pad-bot-50">
                    <div class="center-align pad-top-25">
                        <div class="medium-circle bg-dark footer no-overflow" style="border:3px solid #FFF; margin-top:-75px"></div> 
                            <form method="POST" action="{{route('upload.avatar')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}    
                                <label for="imgField" class="btn btn-md btn-black capitalize"><span class="fa fa-camera"></span> Choose Photo</label>
                                <input type="file" class="hidden" id="imgField" name="image" required/>
                                <button type="submit" class="btn btn-md btn-primary capitalize"><span class="fa fa-cloud-upload"></span> Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection