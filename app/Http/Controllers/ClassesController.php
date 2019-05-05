<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes;
use App\Comments;
use App\Courses;
use Auth;
use App\subscriptions;
use App\assignedTo;
use App\Reviews;
use Illuminate\Support\Facades\Input;
use App\attachments;
use Storage;

class ClassesController extends Controller
{
    //open class content
    public function openClass($id){
        // get class data
        $class = classes::findorfail($id);
        $isAssigned = false;
        // check if the user is logged in
        if(Auth::check()){
            // check if user is a student
            if(Auth::user()->isStudent()){
                // chcek if the logged in user has 
                // seen this class
                $check = subscriptions::where("class_id", $id)->where("student_id", Auth::user()->id)->get();
                if(count($check) == 0){
                    // make a record of the student visiting the class
                    $subscribe = new subscriptions;
                    $subscribe->class_id = $id;
                    $subscribe->student_id = Auth::user()->id;
                    $subscribe->save();
                }
            }
            // check if the user is the owner of the class
            if($class->instructor_id == Auth::user()->id){
                // check for any unseen reviews
                $unseenReviews = Reviews::where("receiver_id", Auth::user()->id)->where("class_id", $class->id)->where("seen", false)->get();
                foreach ($unseenReviews as $key => $review) {
                    $_review = Reviews::find($review->id);
                    $_review->seen = true;
                    $_review->save();
                }
            }
            // check if user is the moderator assigned to the course
            $checkAssigned = assignedTo::where("moderator_id", Auth::user()->id)->where("course_id", $class->course_id)->take(1)->get();
            if(count($checkAssigned) > 0 || Auth::user()->isAdmin()){
                $isAssigned = true;
            }

        }
        return view("classes/index")->with("params", [
            "class" => $class,
            "isAssigned" => $isAssigned
        ]);
    }

    // add comment
    public function addComment(Request $request){
        $class_id = $request->input("class_id");
        $_comment = $request->input("comment");
        if(strlen($_comment) > 0 && (Auth::user()->isStudent() || Auth::user()->isInstructor())){
        $comment = new Comments;
        $comment->user_id = Auth::user()->id;
        $comment->class_id = $class_id;
        $comment->comment = nl2br($_comment);
        $comment->save();
        return redirect("/classes/$class_id")->with("success", "Comment Added Successfully!");
        }else{
            return redirect("/classes/$class_id");
        }
    }

    // delete class
    public function deleteClass($id, $redirect="null"){
        // delete all comments
        $comments = Comments::where("class_id", $id)->get();
        foreach ($comments as $key => $comment) {
            $thisComment = Comments::find($comment->id);
            $thisComment->forceDelete();
        }
        // delete all relating files
        $attachs = attachments::where("class_id", $id)->get();
        foreach($attachs as $key => $attach){
            Storage::disk('public')->delete($attach->filename);
            $thisAttach = attachments::find($attach->id);
            $thisAttach->forceDelete();
        }
        // delete all subscriptions
        $subscriptions = subscriptions::where("class_id", $id)->get();
        foreach ($subscriptions as $key => $subscription) {
            $thisSub = subscriptions::find($subscription->id);
            $thisSub->forceDelete();
        }
        // delete all reviews
        $Reviews = Reviews::where("class_id", $id)->get();
        foreach ($Reviews as $key => $Review) {
            $thisRev = Reviews::find($Review->id);
            $thisRev->forceDelete();
        }
        // delete class
        $class = classes::findorfail($id);
        $instructor_id = $class->instructor_id;
        $class->forceDelete();
        // get number of classes
        $all_classes = classes::where("instructor_id", $instructor_id)->get();
        if($redirect == "null"){
            return "<span class='hidden response' data-response='1' data-num-classes='".number_format(count($all_classes))."'></span>";
        }else{
            return redirect(route($redirect));
        }
    }

    // add class
    public function addClass(Request $request){
        $class_id = $request->input("class_id");
        $course_id = $request->input("course_id");
        $class_title = $request->input("class_title");
        $article = $request->input("article");
        $class = classes::find($class_id);
        $class->course_id = $course_id;
        $class->instructor_id = Auth::user()->id;
        $class->class_title = $class_title;
        $class->article = nl2br($article);
        $class->status = "PENDING";
        $class->save();
        return redirect(route("instructor.dashboard"))->with("success", "A new class <b>".strtoupper($class_title)."</b> was added successfully.<br> It is now being reviewed by our experts.");
    }

    // update class
    public function updateClass(Request $request){
        $class_id = $request->input("class_id");
        $course_id = $request->input("course_id");
        $class_title = $request->input("class_title");
        $article = $request->input("article");
        $class = classes::find($class_id);
        $class->course_id = $course_id;
        // confirm that the user is the author of the article
        if($class->instructor_id == Auth::user()->id){
            $class->class_title = $class_title;
            $class->article = nl2br($article);
            $class->status = "PENDING";
            $class->save();
            // add review
            $review = new Reviews;
            $review->class_id = $class_id;
            $review->instructor_id = Auth::user()->id;
            $review->review = "-- Some changes were made by the author --";
            $review->save();

            return redirect(route("instructor.dashboard"))->with("success", "Changes made to the class have been saved successfully.<br> It is now being reviewed by our experts.");
        }else{
            return redirect(route("home"));
        }
    }
    // route to edit class page
    public function editClass($id){
        // check if user is an instructor and is the author or the article
        if(Auth::user()->isInstructor()){
            // get class info
            $class = classes::findorfail($id);
            if(Auth::user()->id == $class->instructor_id){
                $courses = Courses::orderBy("course_title", "ASC")->get();
                return view("/instructor/editClass")->with("params", [
                    "courses" => $courses,
                    "class" => $class
                ]);
            }else{
                $class = classes::findorfail(null);
            }
        }
    }
    // upload file
    public function uploadFile(){
        $data = Input::all();
        //get the base-64 from data
        $base64_str = substr($data['file'], strpos($data['file'], ",")+1);
        //decode base64 string
        $image = base64_decode($base64_str);
        $ext = "png";
        $filename = randomString().".".$ext;
        Storage::disk('public')->put($filename, $image);
        $storagePath = env("APP_URL")."/storage//".$filename;
        // save file details
        $attach = new attachments;
        $attach->class_id = $data['class_id'];
        $attach->uri = $storagePath;
        $attach->filename = $filename;
        $attach->caption = $data['caption'];
        $attach->save();
        $response = array(
            'status' => 'success',
            'attachment_id' => $attach->id,
            'attachment_uri' => $storagePath,
            'attachment_caption' => $data['caption']
        );
        return $response;
    }
    // delete attachment
    public function deleteAttachment($id){
        $attach = attachments::findorfail($id);
        Storage::disk('public')->delete($attach->filename);
        $attach->forceDelete();
        return array(
            'status' => 'success'
        );
    }
}


function randomString($length = 25) {
    $str = "";
    $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
