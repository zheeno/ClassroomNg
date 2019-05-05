$(".course-sub-tog-btn").on("click", function(event) {
    event.preventDefault();
    const course_id = Number($(this).attr("data-course-id"));
    const sending = $(this).attr("data-sending");
    $(".course-sub-tog-btn").addClass("animated pulse infinite");
    if (sending == "false") {
        $(".course-sub-tog-btn").attr("data-sending", "true");
        $(".course-sub-tog-btn").addClass("animated pulse infinite");
        $("#temp").load(
            "/courses/" + course_id + "/togSubscription",
            function() {
                $(".course-sub-tog-btn").attr("data-sending", "false");
                const response = $("#temp>.sub-response").attr("data-response");
                $(".course-sub-tog-btn").attr("data-state", response);
                if (Number(response) == 0) {
                    // unsubscribed
                    $(".course-sub-tog-btn .fa")
                        .addClass("fa-bell")
                        .removeClass("fa-bell-slash");
                    $(".course-sub-tog-btn")
                        .removeClass("btn-danger  animated pulse infinite")
                        .addClass("btn-primary");
                    $(".course-sub-tog-btn .text").text("Subscribe");
                } else {
                    // subscribed
                    $(".course-sub-tog-btn .fa")
                        .addClass("fa-bell-slash")
                        .removeClass("fa-bell");
                    $(".course-sub-tog-btn")
                        .addClass("btn-danger")
                        .removeClass("btn-primary animated pulse infinite");
                    $(".course-sub-tog-btn .text").text("Unsubscribe");
                }
            }
        );
    }
});

// toggle follow instructor
$(".instructor-sub-tog-btn").on("click", function(event) {
    event.preventDefault();
    const instructor_id = Number($(this).attr("data-instructor-id"));
    const sending = $(this).attr("data-sending");
    $(".instructor-sub-tog-btn").addClass("animated pulse infinite");
    if (sending == "false") {
        $(".instructor-sub-tog-btn").attr("data-sending", "true");
        $(".instructor-sub-tog-btn").addClass("animated pulse infinite");
        $("#temp").load(
            "/instructors/" + instructor_id + "/togFollow",
            function() {
                $(".instructor-sub-tog-btn").attr("data-sending", "false");
                const response = $("#temp>.sub-response").attr("data-response");
                const new_followers = $("#temp>.sub-response").attr(
                    "data-followers"
                );
                $(".followers-holder").text(new_followers);
                $(".instructor-sub-tog-btn").attr("data-state", response);
                if (Number(response) == 0) {
                    // unfollowed
                    $(".instructor-sub-tog-btn .fa")
                        .addClass("fa-plus-circle")
                        .removeClass("fa-minus-circle");
                    $(".instructor-sub-tog-btn")
                        .removeClass("btn-danger  animated pulse infinite")
                        .addClass("btn-primary");
                    $(".instructor-sub-tog-btn .text").text("Follow");
                } else {
                    // followed
                    $(".instructor-sub-tog-btn .fa")
                        .addClass("fa-minus-circle")
                        .removeClass("fa-plus-circle");
                    $(".instructor-sub-tog-btn")
                        .addClass("btn-danger")
                        .removeClass("btn-primary animated pulse infinite");
                    $(".instructor-sub-tog-btn .text").text("Unfollow");
                }
            }
        );
    }
});

// hijack links
$(".link").on("click", function(event) {
    event.preventDefault();
    const href = $(this).attr("data-href");
    window.location = href;
});

// handle class delete button click
$(".class-delete-btn").on("click", function(event) {
    event.preventDefault();
    const class_id = $(this).attr("data-class-id");
    $("#mainModal .modal-title").text("Delete Class");
    $("#mainModal .modal-body").html(
        `
    <div class="center-align">
        <h5 class="h5-responsive">Deleting this class would remove
        all relating data permanently from our Knowledge Base.</h5>
        <h3 class="h3-responsive">Do you wish to proceed</h3>
    </div>
    <div class="center-align">
        <a onClick="deleteClass(` +
            class_id +
            `)" class="btn btn-primary btn-md capitalize">Yes</a>
        <a data-dismiss="modal" class="btn btn-default btn-md capitalize">No</a>
    </div>
    `
    );
    $("#mainModal").modal("show");
});
// delete class
function deleteClass(class_id) {
    $("#mainModal").modal("hide");
    $("#class_" + class_id)
        .addClass("blur disabled")
        .load("/classes/" + class_id + "/delete", function() {
            const num_classes = $("#class_" + class_id + " .response").attr(
                "data-num-classes"
            );
            $("#class_" + class_id).addClass("animated slideOutLeft");
            setTimeout(() => {
                $("#class_" + class_id).remove();
            }, 1500);

            // run this last
            $(".classes-holder").text(num_classes);
        });
}

// review approval buttons
$(".btn-rev-app, .btn-rev-rej").on("click", function(event) {
    event.preventDefault();
    const state = $(this).attr("data-state");
    const value = $(this).attr("data-value");
    const type = $(this).attr("data-type");
    switch (type) {
        case "rej":
            if (state == "false") {
                // select reject
                $(".btn-rev-rej")
                    .removeClass("grey lighten-3")
                    .addClass("red darken-3 white-text")
                    .attr("data-state", "true");
                $(".btn-rev-app")
                    .addClass("grey lighten-3")
                    .removeClass("green darken-1 white-text")
                    .attr("data-state", "false");
                $("#revStat").val(value);
                $("#revText").attr("required", "true");
            }
            break;

        default:
            if (state == "false") {
                // select approve
                $(".btn-rev-app")
                    .removeClass("grey lighten-3")
                    .addClass("green darken-1 white-text")
                    .attr("data-state", "true");
                $(".btn-rev-rej")
                    .addClass("grey lighten-3")
                    .removeClass("red darken-3 white-text")
                    .attr("data-state", "false");
                $("#revStat").val(value);
                $("#revText").removeAttr("required");
            }
            break;
    }
});

$(".show-notifs").on("click", function(event) {
    event.preventDefault();
    $("#mainModal .modal-title").text("Notification");
    $("#mainModal .modal-body")
        .html(
            `
        <div class="center-align pad-top-25">
            <span class="fa fa-spinner fa-spin fa-4x"></span>
            <h5 class="h5-responsive">Fetching, Please Wait...</h5>
        </div>
    `
        )
        .load("/instructor/showClassesNotifs", function() {
            $(".show-notifs").removeClass("animated pulse infinite");
        });

    $("#mainModal").modal("show");
});

$(".modSelector").on("click", function(event) {
    event.preventDefault();
    const modId = $(this).attr("data-id");
    const modName = $(this).attr("data-name");
    $("#modId").val(modId);
    $("#modName").text(modName);
    $(".modSelSubBtn")
        .removeClass("disabled")
        .removeAttr("disabled");
});

// modify user's permission
$(".permModBtn").on("click", function(event) {
    event.preventDefault();
    $("#mainModal .modal-title").text("Change User's Permission");
    $("#mainModal .modal-body").html(`
        <div class="center-align pad-top-25">
            <span class="fa fa-info-circle fa-2x"></span>
            <h5 class="h5-responsive">Do you wish to change this user's permission level?</h5>
            <a onClick="$('#mainModal').modal('hide');$('#changePermForm').submit()" class="btn btn-primary btn-md capitalize">Yes</a>
            <a data-dismiss="modal" class="btn btn-default btn-md capitalize">No</a>
        </div>
    `);

    $("#mainModal").modal("show");
});

$(".permSelector").on("click", function(event) {
    event.preventDefault();
    const code = $(this).attr("data-code");
    const name = $(this).attr("data-name");
    $("#permSelName").text(name);
    $("#newPerm").val(code);
    $(".permModBtn")
        .removeAttr("disabled")
        .removeClass("disabled");
});

// remove moderator
$(".remModBtn").on("click", function(event) {
    event.preventDefault();
    const course_id = $(this).attr("data-course-id");
    const mod_id = $(this).attr("data-id");
    $("#mainModal .modal-title").text("Remove Moderator");
    $("#mainModal .modal-body").html(
        `
        <div class="center-align pad-top-25">
            <span class="fa fa-info-circle fa-2x"></span>
            <h5 class="h5-responsive">Do you wish to revoke review previledges for this moderator with respect to this course?</h5>
            <a onClick="$('#mainModal').modal('hide');window.location='/admin/courses/` +
            course_id +
            `/` +
            mod_id +
            `/revokeRevPrv'" class="btn btn-primary btn-md capitalize">Yes</a>
            <a data-dismiss="modal" class="btn btn-default btn-md capitalize">No</a>
        </div>
    `
    );
    $("#mainModal").modal("show");
});

// account selector during sign up
$(".accTypeSel").on("click", function(event) {
    const perm = $(this).attr("data-acc");
    $("#perm").val(perm);
    switch (perm) {
        case "instructor":
            $(".stu-sel").removeClass("grey darken-4 white-text");
            $(".stu-sel>.fa")
                .removeClass("fa-check-circle green-ic")
                .addClass("fa-circle-o grey-ic");
            $(".inst-sel").addClass("grey darken-4 white-text");
            $(".inst-sel>.fa")
                .removeClass("fa-circle-o grey-ic")
                .addClass("fa-check-circle green-ic");
            break;

        default:
            $(".stu-sel").addClass("grey darken-4 white-text");
            $(".stu-sel>.fa")
                .removeClass("fa-circle-o grey-ic")
                .addClass("fa-check-circle green-ic");
            $(".inst-sel").removeClass("grey darken-4 white-text");
            $(".inst-sel>.fa")
                .removeClass("fa-check-circle green-ic")
                .addClass("fa-circle-o grey-ic");
            break;
    }
});

// add course
$(".add-course-init-btn").on("click", function(event) {
    $("#mainModal .modal-title").text("Add Course");
    $("#mainModal .modal-body")
        .html(
            `<div class="center-align">
                <span class="fa fa-spinner fa-spin fa-4x"></span>
                <h5 class="h5-responsive">Fetching... Please wait</h5>
            </div>`
        )
        .load("/admin/addCourse", function() {
            //
        });
    $("#mainModal").modal("show");
});

// edit course
$(".edit-course-btn").on("click", function(event) {
    const course_id = $(this).attr("data-course-id");
    $("#mainModal .modal-title").text("Edit Course");
    $("#mainModal .modal-body")
        .html(
            `<div class="center-align">
                <span class="fa fa-spinner fa-spin fa-4x"></span>
                <h5 class="h5-responsive">Fetching... Please wait</h5>
            </div>`
        )
        .load("/admin/viewCourses/" + course_id + "/edit", function() {
            //
        });
    $("#mainModal").modal("show");
});

// delete course
$(".delete-course-btn").on("click", function(event) {
    const course_id = $(this).attr("data-course-id");
    $("#mainModal .modal-title").text("Delete Course");
    $("#mainModal .modal-body").html(
        `<div class="center-align pad-top-25">
            <span class="fa fa-info-circle fa-2x"></span>
            <h5 class="h5-responsive">Deleting this course will permanently remove all relating data from the knowledge base.<br>Do you wish to proceed?</h5>
            <a onClick="$('#mainModal').modal('hide');window.location='/admin/courses/` +
            course_id +
            `/deleteCourse'" class="btn btn-primary btn-md capitalize">Yes</a>
            <a data-dismiss="modal" class="btn btn-default btn-md capitalize">No</a>
        </div>`
    );
    $("#mainModal").modal("show");
});
// delete user account
$(".user-acc-del-btn").on("click", function(event) {
    event.preventDefault();
    const user_id = $(this).attr("data-user-id");
    $("#mainModal .modal-title").text("Delete Account");
    $("#mainModal .modal-body").html(
        `<div class="center-align pad-top-25">
            <span class="fa fa-info-circle fa-2x"></span>
            <h5 class="h5-responsive">Deleting this user's account will permanently remove all relating data from the knowledge base.<br>Do you wish to proceed?</h5>
            <a onClick="$('#mainModal').modal('hide');window.location='/admin/users/` +
            user_id +
            `/deleteUser'" class="btn btn-primary btn-md capitalize">Yes</a>
            <a data-dismiss="modal" class="btn btn-default btn-md capitalize">No</a>
        </div>`
    );
    $("#mainModal").modal("show");
});
// add image to class content
selectors = 0;
limit = 5;
$(".add-img-btn").on("click", function() {
    $("#largeModal .modal-title").html(`Add Image 
        <label for="tempImgSelector" class="sel-img-h-btn btn btn-md pull-right transparent capitalize">
         <span class="fa fa-photo black-text"></soan>
         </label>
    `);
    $("#largeModal .modal-body").html(`
        <div class='row'>
            <div class="col-12 center-align no-overflow">
                <img id="imgPreview" class="hidden" style="max-width: 100%;" />
            </div>
        </div>
        <form class="row" onSubmit="addNewImgToImgList(event)">
            <div class="md-form col-md-10 mx-auto">
                <label>Caption</label>
                <input type="file" class="hidden" accept="image/*" id="tempImgSelector" onChange="previewImageBeforeUpload(event)" required />
                <input type="text" class="form-control" id="imgCaptionText" required/>
            </div>
            <div class="col-12 center-align">
                <button type="button" class="btn btn-grey btn-md" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-md">Add Image</button>
            </div>
        </form>
    `);
    $("#largeModal").modal("show");
});

function previewImageBeforeUpload(evt) {
    var f = evt.target.files[0]; // FileList object
    if (f != null) {
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                var binaryData = e.target.result;
                //Converting Binary Data to base 64
                var base64String = window.btoa(binaryData);
                //showing file converted to base64
                $("#imgPreview")
                    .removeClass("hidden")
                    .attr("src", "data:image/jpeg;base64," + base64String);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsBinaryString(f);
    } else {
        $("#imgPreview")
            .addClass("hidden")
            .removeAttr("src");
    }
}

// set image selected
function addNewImgToImgList(event) {
    event.preventDefault();
    file = $("#imgPreview").attr("src");
    caption = $("#imgCaptionText").val();
    class_id = $("#class_id").val();
    if (selectors < limit) {
        var files = $("#tempImgSelector").prop("files");
        $("#largeModal .modal-body").html(`<div class="center-align pad-top-25 pad-bot-25">
            <span class="fa fa-spinner fa-spin fa-4x"></span>
            <h5 class="h5-responsive">Uploading... Please wait</h5>
        </div>`);
        $('.sel-img-h-btn').remove();
        $("#largeModal").modal("show");
        for (var i = 0; i < files.length; i++) {
            (function(file) {
                if (file.type.indexOf("image") == 0) {
                    var fileReader = new FileReader();
                    fileReader.onload = function(f) {
                        $.ajax({
                            type: "POST",
                            url: "/classes/uploadFile",
                            data: {
                                _token: document.getElementsByName("_token")[1]
                                    .value,
                                file: f.target.result,
                                name: file.name,
                                class_id: class_id,
                                caption: caption
                            },
                            success: function(result) {
                                if (result.status == "success") {
                                    $("#largeModal").modal("hide");
                                    imgSelector =
                                        `<div id="selector_` +
                                        result.attachment_id +
                                        `" class="preview-img-btn col-md-2 col-lg-3 card pad-0" style="margin:20px;background-image:url('` +
                                        result.attachment_uri +
                                        `');background-size:cover;background-position:top;background-repeat:no-repeat">
                                                <div class="card-body center-align" style="height:80px">
                                                    <a onClick="removeImgFromImgList(` +
                                        result.attachment_id +
                                        `)" class="btn pad-0 btn-circle-sm bg-dark" style="right:-15px;top:-15px;position:absolute"><span class="fa fa-times white-text" style="    font-size: 20px;
                                                        margin: 4px;"></span>
                                                    </a>
                                                </div>
                                                <a onClick="prevAttachImage('`+result.attachment_uri+`','`+result.attachment_caption+`')" class="open-img card-footer bg-dark pad-0 m-0" style="padding:5px 10px 10px 10px !important">
                                                    <p class="white-text m-0">` +
                                        result.attachment_caption +
                                        `</p>
                                                </a>
                                            </div>`;
                                    selectors++;
                                    $(".img-list").append(imgSelector);
                                    $("#hasImg").val("true");
                                    $("#numImg").val(selectors);
                                    if (selectors == limit) {
                                        $(".add-img-btn").addClass(
                                            "disabled hidden"
                                        );
                                    }
                                }
                            }
                        });
                    };

                    fileReader.readAsDataURL(file);
                }
            })(files[i]);
        }
    } else {
        alert("You have reached the limit");
    }
}
// remove selected image
function removeImgFromImgList(sel) {
    $("#selector_" + sel)
        .addClass("blur disabled")
        .load("/attachment/delete/"+sel, function() {
            $("#selector_" + sel).remove();
            selectors--;
            $("#numImg").val(selectors);
            if (selectors < limit) {
                $(".add-img-btn").removeClass("disabled hidden");
            }
            if (selectors == 0) {
                $("#hasImg").val("false");
            }
        });
}
// change avatar btn
$(".chg-ava .btn").on("click", function(event) {
    event.preventDefault();
    $("#avatarModal").modal("show");
});
// change password
$(".chg-pwd").on("click", function(event) {
    event.preventDefault();
    $("#mainModal .modal-title").text("Change Password");
    $("#mainModal .modal-body").html(
        `<div class="center-align pad-top-25">
                <form method="POST" action="/changePass">
                    <div class="md-form">
                        <label>New Password</label>
                        <input id="pwd_1" type="password" class="form-control" name="newPwd" required/>
                    </div>
                    <div class="md-form">
                        <label>Confirm Password</label>
                        <input id="pwd_2" type="password" class="form-control" required/>
                    </div>
                    <div class="center-align">
                        <button type="submit" class="btn btn-md btn-primary capitalize">Change Password</button>
                        <button type="button" class="btn grey lighten-2 btn-md capitalize" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>`
    );
    $("#mainModal").modal("show");
});

$(".attachments").ready(function(){
    count = parseInt($('.attachments').attr('data-count'));
    selectors = count;
    if(count < 5){
        $(".add-img-btn").removeClass("disabled hidden")
    }else{
        $(".add-img-btn").addClass("disabled hidden")
    }
});

$(".open-img").on("click", function(){
    uri = $(this).attr('data-uri');
    caption = $(this).attr('data-caption');
    prevAttachImage(uri, caption);
});

function prevAttachImage(uri, caption){
    $("#largeModal .modal-title").text(caption);
    $("#largeModal .modal-body").html(`<img src="`+uri+`" style="width:100%"/>`);
    $("#largeModal").modal("show");
}

$(".discard-class-btn").on("click", function(evt){
    evt.preventDefault();
    const class_id = $(this).attr("data-class-id");
    $("#mainModal .modal-title").text("Delete Class");
    $("#mainModal .modal-body").html(
        `
    <div class="center-align">
        <h5 class="h5-responsive">Deleting this class would remove
        all relating data permanently from our Knowledge Base.</h5>
        <h3 class="h3-responsive">Do you wish to proceed</h3>
    </div>
    <div class="center-align">
        <a href="/classes/` +
            class_id +
            `/instructor.dashboard/delete" class="btn btn-primary btn-md capitalize">Yes</a>
        <a data-dismiss="modal" class="btn btn-default btn-md capitalize">No</a>
    </div>
    `
    );
    $("#mainModal").modal("show");
})