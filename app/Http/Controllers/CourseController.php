<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courses;
use App\classes;
use App\subscriptions;
use Auth;


class CourseController extends Controller
{
    public function index(){
        $courses = Courses::orderBy("course_title", "ASC")->paginate(6);
        return view("courses/index")->with("params", [
            "courses" => $courses,
            "title" => null
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
        return view('courses/index')->with("params", [
            "courses" => $courses,
            "title" => "Search Results for <small><i>&quot;".$request->input('q')."&quot;</i></small>"
        ]);
    }

    public function openCourse($course_title){
        // get id 
        $_c = Courses::where("course_title", $course_title)->take(1)->get();
        if(count($_c) > 0){
        $id = $_c[0]->id;
        $course = Courses::findOrFail($id);
        // get all courses
        $courses = Courses::orderBy("course_title", "ASC")->get();
        // get all classes
        $classes = classes::where("course_id", $id)->where("status", "APPROVED")->orderBy("id", "DESC")->paginate(10);
        // if user is logged in, check if the user is subscribed to the course
        if(Auth::check()){
            $subscribed = subscriptions::where("course_id", $id)->where("student_id", Auth::user()->id)->get();
        }else{
            $subscribed = [];
        }
        switch (count($subscribed)) {
            case 1:
                $_subscribed = true;
                break;
            
            default:
                $_subscribed = false;
                break;
        }
        return view("courses/courseContent")->with("params", [
            "course" => $course,
            "courses" => $courses,
            "classes" => $classes,
            "subscribed" => $_subscribed
        ]);
        }else{
            $course = Courses::findOrFail(null);   
        }
    }

    public function togCourseSubscription($id){
        // check if user has subscribed to the course
        $check = subscriptions::where("course_id", $id)->where("student_id", Auth::user()->id)->get();
        if(count($check) > 0){
            // user has subscribed to the course
            // user should be unsubscribed from the course
            $subscription = subscriptions::find($check[0]->id);
            $subscription->forceDelete();
            return "<span class='sub-response' data-response='0'></span>";
        }else{
            if(Auth::user()->isStudent()){ //check if user is a student 
                $subscription = new subscriptions; 
                $subscription->student_id = Auth::user()->id;
                $subscription->course_id = $id;
                $subscription->save();
                return "<span class='sub-response' data-response='1'></span>";
            }else{
                return "<span class='sub-response' data-response='0'></span>";
            }
        }
    }
    // randomly display classes to the user
    public function educateMe(){
        // get all classes
        $classes = classes::inRandomOrder()->where("status", "APPROVED")->paginate(10);
        return view("/courses/educateMe")->with("params", [
            "classes" => $classes,
            "title" => null
        ]);
    }
    // search classes
    public function searchClasses(Request $request){
        $input = $request->input();
        $keywords = $request->input('q');
        $keywords = explode(" ", $keywords);
        $classes = classes::where(function($query) use($keywords){
            foreach ($keywords as $key => $keyword){
                if($keyword != ''){
                    $query->where("class_title", 'LIKE', "%".$keyword."%")
                    ->orWhere("article", 'LIKE', "%".$keyword."%");
                }
            }
        })->where("status", "APPROVED")
        ->orderBy('id', 'DESC')->paginate(10);
        $classes->appends($input);
        return view('/courses/educateMe')->with("params", [
            "classes" => $classes,
            "title" => "Search Results for <small><i>&quot;".$request->input('q')."&quot;</i></small>"
        ]);
    }
    
    public function refundPolicy(){
        return view("/refundPolicy");
    }
}
