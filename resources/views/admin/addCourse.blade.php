
<div class="container-fluid">
    <div class="row pad-top-25">
        <div class="col-12">
            <div class="alert alert-info">
                Create a new course to enable
                instructors create more classes 
                for a new subject area.
            </div>
        </div>
    </div>
    <form class="row" method="POST" action="{{ route('admin.postNewCourse') }}">
        @csrf
        <div class="col-12 md-form">
            <label>Course Title</label>
            <input type="text" class="form-control" name="course_title" required/>
        </div>
        <div class="col-12 md-form">
            <label>Description</label>
            <textarea class="md-textarea w-100" name="description" required></textarea>
        </div>
        <div class="col-12 center-align">
            <button type="submit" class="btn btn-primary btn-md capitalize"><span class="fa fa-plus"></span> Add Course</button>
        </div>
    </form>
</div>
