<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Courses;
use App\assignedTo;
use App\classes;
use App\Reviews;


class ModeratorController extends Controller
{
    public function dashboard(){
        // fetch all courses assigned to this moderator
        $assignedCourses = assignedTo::where("moderator_id", Auth::user()->id)->orderBy("id", "DESC")->paginate(6);
        return view("/moderator/index")->with("params", [
            "assignedCourses" => $assignedCourses
        ]);
    }

    public function reviewCourse($id){
        // find course
        $course = Courses::findorfail($id);
        // check if moderator is assigned to this course
        $assigned = assignedTo::where("moderator_id", Auth::user()->id)->where("course_id", $id)->take(1)->get();
        if(count($assigned) > 0 || Auth::user()->isAdmin()){
            $inReview = classes::where("course_id", $id)->where("status", "!=", "APPROVED")->orderBy("updated_at", "DESC")->paginate(5);
            // fetch all courses assigned to this moderator
            $assignedCourses = assignedTo::where("moderator_id", Auth::user()->id)->orderBy("id", "DESC")->paginate(6);
            return view("/moderator/reviewCourse")->with("params", [
                "inReview" => $inReview,
                "assignedTo" => $assignedCourses,
                "course" => $course
            ]);
        }else{
            $course = Courses::findorfail(null);
        }
    }

    // add review
    public function addReview(Request $request){
        $class_id = $request->input("class_id");
        $status = $request->input("status");
        $_review = $request->input("review");
        // find the class
        $class = classes::findorfail($class_id);
        // check if the use is allowed to review the class
        $check = assignedTo::where("moderator_id", Auth::user()->id)->where("course_id", $class->course_id)->take(1)->get();
        if(count($check) == 1 || Auth::user()->isAdmin()){
            // add review
            $review = new Reviews;
            $review->class_id = $class_id;
            $review->receiver_id = $class->instructor_id;
            $review->moderator_id = Auth::user()->id;
            $review->review = "-- <b>".$status."</b> --<br>".$_review;
            $review->save();
            // change status of the class
            $class->status = $status;
            $class->save();
            return redirect("/classes/$class_id")->with("revSuccess", "Review has been added successfully");
        }else{
            $class = classes::findorfail(null);
        }
    }
}
