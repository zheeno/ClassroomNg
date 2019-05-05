<form class="row bg-white" action="/search/classes" method="GET">
    @csrf
    <div class="col-md-8" style="padding:0px;padding-top:10px;">
        <input name="q" type="text" class="form-control no-border no-radius" placeholder="Search Topics" required/>
    </div>
    <div class="col-md-4 center-align" style="padding:0px;padding-bottom:10px">
        <button class="btn btn-primary btn-md capitalize no-radius" style="top:7px;position:relative" type="submit"><span class="fa fa-search"></span> Search</button>
    </div>
</form>
