<div class="row">
    <ul class="list-group col-12">
        <li data-href="{{ route('instructor.addClass') }}" class="link btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize"><span class="fa fa-plus"></span>&nbsp;Add Class&nbsp;<span class="fa fa-angle-right m-1 pull-right grey-text"></span></li>
        <li data-href="{{ route('home') }}" class="link btn no-radius no-shadow btn-block btn-md btn-dark left-align capitalize"><span class="fa fa-list"></span>&nbsp;Classes&nbsp;<span class="fa fa-angle-right m-1 pull-right grey-text"></span></li>
        <li class="show-notifs btn no-radius no-shadow btn-block btn-md @if(count(Auth::user()->unreadNotifs) > 0) cyan darken-3 animated pulse infinite @else btn-dark disabled @endif left-align capitalize"><span class="fa fa-comment"></span>&nbsp;Notification&nbsp;<span class="fa fa-angle-right m-1 pull-right grey-text"></span></li>

    </ul>
</div>