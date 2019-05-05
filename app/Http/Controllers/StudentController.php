<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Courses;
use App\classes;
use App\subscriptions;

class StudentController extends Controller
{
    //display to dashboard
    public function dashboard(){
        // get all recent feeds of all courses which student is subscribed to
        $classes = classes::where(function($q){
            $course_ids = []; $inst_ids = [];
            $course_sub = subscriptions::where("student_id", Auth::user()->id)->where("course_id", "!=", null)->get();
            foreach ($course_sub as $key => $sub) {
                array_unshift($course_ids, $sub->class_id);
            }
            $instructor_sub = subscriptions::where("student_id", Auth::user()->id)->where("instructor_id", "!=", null)->get();
            foreach ($instructor_sub as $key => $sub) {
                // check for all classes created by the instructor
                array_unshift($inst_ids, $sub->instructor_id);
            }
            $q->whereIn("course_id", $course_ids)->orWhereIn("instructor_id", $inst_ids);
        })->where("status", "APPROVED")->orderBy('updated_at', 'DESC')->paginate(10);

        return view("students/index")->with('params', [
            'classes' => $classes
        ]);
    }
}
