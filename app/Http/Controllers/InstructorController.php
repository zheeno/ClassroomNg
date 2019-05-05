<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\classes;
use App\subscriptions;
use App\Courses;
use App\Reviews;
use Auth;


class InstructorController extends Controller
{
    // show all instructors
    public function index(){
        $instructors = User::where("permission", 701)->orderBy("id", "DESC")->paginate(10);
        return view("instructors/index")->with("params", [
            "instructors" => $instructors,
            "title" => null
        ]);
    }
    // search Instructors
    public function searchInstructors(Request $request){
        $input = $request->input();
        $keywords = $request->input('q');
        $keywords = explode(" ", $keywords);
        $instructors = User::where(function($query) use($keywords){
            foreach ($keywords as $key => $keyword){
                if($keyword != ''){
                    $query->where('name', 'LIKE', "%".$keyword."%");
                }
            }
        })->where("permission", 701)
        ->orderBy('id', 'DESC')->paginate(10);
        $instructors->appends($input);
        return view("instructors/index")->with("params", [
            "instructors" => $instructors,
            "title" => "Search Results for <small><i>&quot;".$request->input('q')."&quot;</i></small>"
        ]);
    }

    //open selected intructor's page
    public function instructorPage($id){
        $user = User::findorfail($id);
        // check if user is an instructor
        if((int)$user->permission == 701){
            // fetch all classes created by the instructor
            $classes = classes::where("instructor_id", $id)->where("status", "APPROVED")->orderBy("id", "DESC")->paginate(5);
            $all_classes = classes::where("instructor_id", $id)->where("status", "APPROVED")->orderBy("id", "DESC")->get();
            // get number of students subscribed to the instructor
            $sub2ins = subscriptions::where("instructor_id", $id)->get();
            // if user is logged in, check if the user is subscribed to the course
            if(Auth::check()){
                $following = subscriptions::where("instructor_id", $id)->where("student_id", Auth::user()->id)->get();
            }else{
                $following = [];
            }
            switch (count($following)) {
                case 1:
                    $_following = true;
                    break;
                
                default:
                    $_following = false;
                    break;
            }
            return view("instructors/instructorPage")->with("params", [
                "instructor" => $user,
                "classes" => $classes,
                "all_classes" => count($all_classes),
                "followers" => count($sub2ins),
                "following" => $_following
            ]);
        }else{
            $user = User::findorfail(null);
        }
    }

    // toggle instructor follow
    public function togInstructorFollow($id){
        // check if user has subscribed to the instructor
        $check = subscriptions::where("instructor_id", $id)->where("student_id", Auth::user()->id)->get();
        if(count($check) > 0){
            // user has subscribed to the instructor
            // user should be unsubscribed from the instructor
            $subscription = subscriptions::find($check[0]->id);
            $subscription->forceDelete();
            // get new number of followers
            $new_followers = subscriptions::where("instructor_id", $id)->get();
            return "<span class='sub-response' data-response='0' data-followers='".number_format(count($new_followers))."'></span>";
        }else{
            if(Auth::user()->isStudent()){ //check if user is a student 
                $subscription = new subscriptions; 
                $subscription->student_id = Auth::user()->id;
                $subscription->instructor_id = $id;
                $subscription->save();
                // get new number of followers
                $new_followers = subscriptions::where("instructor_id", $id)->get();
                return "<span class='sub-response' data-response='1' data-followers='".number_format(count($new_followers))."'></span>";
            }else{
                // get new number of followers
                $new_followers = subscriptions::where("instructor_id", $id)->get();
                return "<span class='sub-response' data-response='0' data-followers='".number_format(count($new_followers))."'></span>";
            }
        }
    }
     // show all instructors
     public function dashboard(){
        // get all classes created by the instructor
        $classes = classes::where("instructor_id", Auth::user()->id)->orderBy("updated_at", "DESC")->paginate(5);
        $all_classes = classes::where("instructor_id", Auth::user()->id)->orderBy("id", "DESC")->get();
        // get number of students subscribed to the instructor
        $sub2ins = subscriptions::where("instructor_id", Auth::user()->id)->get();
        return view("instructor/index")->with("params", [
            "classes" => $classes,
            "all_classes" => count($all_classes),
            "followers" => count($sub2ins)
        ]);
    }

    // route to add class page
    public function addClass(){
        // create new class
        $class = new classes;
        $class->class_title = "UNTITLED_".Date('Yhis');
        $class->course_id = 0;
        $class->instructor_id = Auth::user()->id;
        $class->article = "";
        $class->status = "DRAFT";
        $class->save();
        // get all courses
        $courses = Courses::orderBy("course_title", "ASC")->get();
        return view("instructor/addClass")->with("params", [
            "courses" => $courses,
            "class" => $class
        ]);
    }

    // show classes with unread notifications
    public function showClassesNotifs(){
        $classes = classes::where(function($q){
            $unseenReviews = [];
            // get list of ids of unseen classes with notifications
            $reviews = Reviews::where("receiver_id", Auth::user()->id)->where("seen", false)->get();
            foreach ($reviews as $key => $review) {
                array_unshift($unseenReviews, $review->class_id);
            }
            $q->whereIn("id", $unseenReviews);
        })->orderBy('updated_at', 'DESC')->get();
        if(count($classes) == 0){
            echo "<span class='fa fa-comment fa-4x black-text'></span>
            <h4 class='h4-responsive black-text'>There are no notifications at the moment</h4>";
        }else{
            // generate list
            $list = "";
            foreach ($classes as $key => $class) {
                if($class->status == "PENDING"){
                    $status = '<span class="fa fa-clock-o orange-text pull-right m-1" style="font-size:15px"></span>'; }
                if($class->status == "REJECTED"){
                    $status = '<span class="fa fa-warning red-text pull-right m-1" style="font-size:15px"></span>'; }
                if($class->status == "APPROVED"){
                    $status = '<span class="fa fa-check-circle green-text pull-right m-1" style="font-size:15px"></span>'; }
                            
                $list .= "<a href='/classes/$class->id' class='list-group-item p-1 waves-effect waves-strong black-text'>".$class->class_title." ".$status."</a>";
            }
            echo("<div class=''>
                <h4 class='h4-responsive black-text'>These classes have some issues that require your attention</h4>
                <ul class='list-group'>".$list."</ul>
                </div>");
        }
    }
}

