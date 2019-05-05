<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Courses;
use App\assignedTo;
use App\classes;
use App\Comments;
use App\Reviews;
use App\subscriptions;
use Auth;

class AdministratorController extends Controller
{
    //
    public function dashboard(){
        $students = User::where("permission", 700)->orderBy("id", "DESC")->get();
        $instructors = User::where("permission", 701)->orderBy("id", "DESC")->get();
        $moderators = User::where("permission", 702)->orderBy("id", "DESC")->get();
        $admins = User::where("permission", 755)->orderBy("id", "DESC")->get();
        $all = User::orderBy("id", "DESC")->get();
        // courses
        $courses = Courses::orderBy("id", "DESC")->get();
        // classes
        $classes = classes::orderBy("id", "DESC")->count();
        return view("/admin/index")->with("params", [
            "users" => [
                "students" => (count($students) / count($all)) * 100,
                "instructors" => (count($instructors) / count($all)) * 100,
                "moderators" => (count($moderators) / count($all)) * 100,
                "admins" => (count($admins) / count($all)) * 100,
                "all" => count($all)
            ],
            "courses" => $courses,
            "classes" => $classes,
        ]);
    }

    public function addCourse(){
        return view("/admin/addCourse");
    }

    public function postNewCourse(Request $request){
        $course_title = $request->input("course_title");
        $description = $request->input("description");
        if(strlen($course_title) > 0){
            $course = new Courses;
            $course->course_title = $course_title;
            $course->description = $description;
            $course->save();
            return redirect(route("admin.viewCourses"))->with("success", "New course <b>$course_title</b> has been created successfully");
        }else{
            return redirect(route("admin.viewCourses"))->with("error", "Error encountered while creating course");
        }
    }

    public function viewCourses(){
        $courses = Courses::orderBy("course_title", "ASC")->paginate(6);
        return view("/admin/allCourses")->with("params", [
            "courses" => $courses,
            "title" => null
        ]);
    }

    public function viewThisCourse($id){
        $course = Courses::findorfail($id);
        $courses = Courses::orderBy("course_title", "ASC")->get();
        // get list of ids of moderators assigned to the course
        $assigns = assignedTo::where("course_id", $id)->get();
        $moderators = [];
        foreach ($assigns as $key => $assign) {
            // get user 
            $moderator = User::where("id", $assign->moderator_id)->get();
            if(count($moderator) > 0){
                array_unshift($moderators, $moderator[0]);
            }
        }
        $allModerators = User::where("permission", 702)->orderBy("name", "ASC")->get();
        $classes = classes::where("course_id", $id)->orderBy("id", "DESC")->paginate(6);
        return view("/admin/courseContent")->with("params", [
            "courses" => $courses,
            "course" => $course,
            "classes" => $classes,
            "moderators" => $moderators,
            "allModerators" => $allModerators
        ]);
    }

    // show all users
    public function allUsers(){
        $users = User::orderby("id", "DESC")->paginate(10);
        return view("/admin/users")->with("params", [
            "title" => "All Users",
            "users" => $users
        ]);
    }

    // show selected group of users
    public function fetchUsers($perm){
        $users = User::where("permission", (int)$perm)->orderby("id", "DESC")->paginate(10);
        switch ((int)$perm) {
            case 755:
                $title = "Administrators";
                break;
            case 702:
                $title = "Moderators";
                break;
            case 701:
                $title = "Instructors";
                break;
            default:
                $title = "Students";
                break;
        }
        return view("/admin/users")->with("params", [
            "title" => $title,
            "users" => $users
        ]);
    }

    // add moderator to a course
    public function addModerator(Request $request){
        $course_id = $request->input('course_id');
        $moderator_id = $request->input('moderator_id');
        // check if the moderator has been assigned to the course
        $check = assignedTo::where("course_id", $course_id)->where("moderator_id", $moderator_id)->count();
        // get moderator data
        $user = User::find($moderator_id);
        if($check == 0){
            $assign = new assignedTo;
            $assign->course_id = $course_id;
            $assign->moderator_id = $moderator_id;
            $assign->save();
            return redirect("/admin/viewCourses/$course_id")->with("success", "<strong>$user->name</strong> has been added as a moderator for this course");
        }else{
            return redirect("/admin/viewCourses/$course_id")->with("error", "<strong>$user->name</strong> already exists as a moderator for this course");
        }
    }

    public function viewUser($id){
        $user = User::findorfail($id);

        return view("/admin/userProfile")->with("params", [
            "user" => $user
        ]);
    }


    public function changePerm(Request $request){
        $user_id = $request->input("user_id");
        $newPerm = $request->input("newPerm");
        $user = User::findorfail($user_id);
        $prevPerm = $user->permission;
        $user->permission = (int)$newPerm;
        $user->save();
        return redirect("/admin/users/$user_id")->with("success", "User's Permission level has been changed from <strong>".getPermName($prevPerm)."</strong> to <strong>".getPermName($newPerm)."</strong>");
    }

    public function revokeRevPrv($course_id, $mod_id){
        // check if the moderator has been assigned to the course
        $check = assignedTo::where("course_id", $course_id)->where("moderator_id", $mod_id)->take(1)->get();
        if(count($check) > 0){
            $assign = assignedTo::find($check[0]->id);
            $assign->forceDelete();
            $user = User::find($mod_id);
            return redirect("/admin/viewCourses/$course_id")->with("success", "You have revoked moderator permission for <strong>$user->name</strong> with respect to this course");
        }else{
            return redirect("/admin/viewCourses/$course_id")->with("error", "Error encountered while revoking moderator's permissions");
        }
    }

    public function editThisCourse($course_id){
        $course = Courses::findorfail($course_id);
        // generate form
        return view("/admin/editCourseForm")->with("params", [
            "course" => $course
        ]);
    }

    public function updateCourse(Request $request){
        $course_id = $request->input('course_id');
        $course_title = $request->input('course_title');
        $description = $request->input('description');
        $course = Courses::findorfail($course_id);
        $course->course_title = $course_title;
        $course->description = $description;
        $course->save();
        return redirect("/admin/viewCourses/$course_id")->with("success", "Changes have been saved successfully");
    }

    public function deleteCourse($course_id){
        // delete all moderator assignments to the course
        $modAsses = assignedTo::where("course_id", $course_id)->get();
        foreach ($modAsses as $key => $modAss) {
            $ass = assignedTo::find($modAss->id);
            $ass->forceDelete();
        }
        // delete all classes
        $classes = classes::where("course_id", $course_id)->get();
        foreach ($classes as $key => $class) {
            // delete all comments for each class
            $comments = Comments::where("class_id", $class->id)->get();
            foreach ($comments as $key => $comment) {
                $_comment = Comments::find($comment->id);
                $_comment->forceDelete();
            }  
            // delete all reviews for each class
            $reviews = Reviews::where("class_id", $class->id)->get();
            foreach ($reviews as $key => $review) {
                $_review = Reviews::find($review->id);
                $_review->forceDelete();
            }
            // delete all subscription to each class
            $subscriptions = subscriptions::where("class_id", $class->id)->get();
            foreach ($subscriptions as $key => $sub) {
                $_sub = subscriptions::find($sub->id);
                $_sub->forceDelete();
            }
            // delete the class
            $_class = classes::find($class->id);
            $_class->forceDelete();
        }
        // delete all subscriptions to the course
        $subscriptions = subscriptions::where("course_id", $course_id)->get();
        foreach ($subscriptions as $key => $sub) {
            $_sub = subscriptions::find($sub->id);
            $_sub->forceDelete();
        }
        // delete the course
        $course = Courses::findorfail($course_id);
        $course_title = $course->course_title;
        $course->forceDelete();
        return redirect("/admin/viewCourses")->with("success", "You have successfully deleted <strong>$course_title</strong> and all related data from the knowledge base");
    }

    // delete user's account
    public function deleteUser($id){
        // delete all assignments to the user
        $modAsses = assignedTo::where("moderator_id", $id)->get();
        foreach ($modAsses as $key => $modAss) {
            $ass = assignedTo::find($modAss->id);
            $ass->forceDelete();
        }
        // delete all classes created by the user
        $classes = classes::where("instructor_id", $id)->get();
        foreach ($classes as $key => $class) {
            // delete all comments for each class
            $comments = Comments::where("class_id", $class->id)->get();
            foreach ($comments as $key => $comment) {
                $_comment = Comments::find($comment->id);
                $_comment->forceDelete();
            }  
            // delete all reviews for each class
            $reviews = Reviews::where("class_id", $class->id)->get();
            foreach ($reviews as $key => $review) {
                $_review = Reviews::find($review->id);
                $_review->forceDelete();
            }
            // delete all subscription to each class
            $subscriptions = subscriptions::where("class_id", $class->id)->get();
            foreach ($subscriptions as $key => $sub) {
                $_sub = subscriptions::find($sub->id);
                $_sub->forceDelete();
            }
            // delete the class
            $_class = classes::find($class->id);
            $_class->forceDelete();
        }
        // delete all subscriptions by the user
        $subscriptions = subscriptions::where("instructor_id", $id)->orWhere("student_id", $id)->get();
        foreach ($subscriptions as $key => $sub) {
            $_sub = subscriptions::find($sub->id);
            $_sub->forceDelete();
        }
        ##########################
        // delete all comments made by the user
        $comments = Comments::where("user_id", $id)->get();
        foreach ($comments as $key => $comment) {
            $_comment = Comments::find($comment->id);
            $_comment->forceDelete();
        }  
        // delete all reviews made by / directed to the user
        $reviews = Reviews::where("moderator_id", $id)->orWhere("instructor_id", $id)->orWhere("receiver_id", $id)->get();
        foreach ($reviews as $key => $review) {
            $_review = Reviews::find($review->id);
            $_review->forceDelete();
        }
        #########################
        // delete account
        $user = User::findorfail($id);
        $user_name = $user->name;
        $user->forceDelete();
        return redirect("/admin/users")->with("success", "User account (<strong>$user_name</strong>) has been deleted successfully");
    }
    // search users
    public function searchUsers(Request $request){
        $input = $request->input();
        $keywords = $request->input('q');
        $keywords = explode(" ", $keywords);
        $users = User::where(function($query) use($keywords){
            foreach ($keywords as $key => $keyword){
                if($keyword != ''){
                    $query->where('name', 'LIKE', "%".$keyword."%")
                    ->orWhere('email', 'LIKE', "%".$keyword."%");
                }
            }
        })->orderBy('id', 'DESC')->paginate(10);
        $users->appends($input);
        return view('/admin/users')->with("params", [
            "users" => $users,
            "title" => "Search Results for <small><i>&quot;".$request->input('q')."&quot;</i></small>"
        ]);
    }
    // search courses
    public function searchCourses(Request $request){
        $input = $request->input();
        $keywords = $request->input('q');
        $keywords = explode(" ", $keywords);
        $courses = Courses::where(function($query) use($keywords){
            foreach ($keywords as $key => $keyword){
                if($keyword != ''){
                    $query->where("course_title", 'LIKE', "%".$keyword."%")
                    ->orWhere("description", 'LIKE', "%".$keyword."%");
                }
            }
        })->orderBy('id', 'DESC')->paginate(10);
        $courses->appends($input);
        return view('/admin/allCourses')->with("params", [
            "courses" => $courses,
            "title" => "Search Results for <small><i>&quot;".$request->input('q')."&quot;</i></small>"
        ]);
    }
}

function getPermName($perm){
    switch ((int)$perm) {
        case 755:
            $name = "Administrator";
            break;
        
        case 702:
            $name = "Moderator";
            break;
            
        case 701:
            $name = "Instructor";
            break;
        default:
            $name = "Student";
            break;
    }
    return $name;
}