<form method='POST' action='/admin/updateCourse'>
    @csrf
    <div class='md-form'>
        <label class='active'>Course Title</label>
        <input type='hidden' name='course_id' value='{{ $params["course"]->id }}' />
        <input type='text' class='form-control' name='course_title' value='{{ $params["course"]->course_title }}' required/>
    </div>
    <div class='md-form'>
        <label class='active'>Description</label>
        <textarea class='md-textarea overflow-y w-100' style='height:200px' name='description' required>{{ $params["course"]->description }}</textarea>
    </div>
    <div class='center-align'>
        <button class='btn btn-primary btn-md capitalize' type='submit'>Save Changes</button>
        <button class='btn btn-default btn-md capitalize' type='button' data-dismiss='modal'>Cancel</button>
    </div>
</form>
