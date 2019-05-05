<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isStudent()){
            return redirect(route('student.dashboard'));
        }elseif(Auth::user()->isInstructor()){
            return redirect(route('instructor.dashboard'));
        }elseif(Auth::user()->isModerator()){
            return redirect(route('moderator.dashboard'));
        }elseif(Auth::user()->isAdmin()){
            return redirect(route('admin.dashboard'));
        }
        else{
            return redirect('/');
        }
    }

    public function myProfile(){
        return view("/profile");
    }

    public function updateProfile(Request $request){
        $name = $request->input('name');
        $first_deg = $request->input('first_deg');
        $high_deg = $request->input('high_deg');
        $inst_high_deg = $request->input('inst_high_deg');
        $other_deg = $request->input('other_deg');
        $bio = $request->input('bio');
        // find user account
        $user = User::findorfail(Auth::user()->id);
        $user->name = $name;
        $user->first_deg = $first_deg;
        $user->high_deg = $high_deg;
        $user->inst_high_deg = $inst_high_deg;
        $user->other_deg = $other_deg;
        $user->bio = $bio;
        $user->save();
        return redirect(route("me.profile"))->with("success", "Changes made to your profile have been saved");
    }

    public function _avatar(Request $request){
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
        ]);
        $dir = "avatars";
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = randomString().".".$ext;
        // check if user has previously set an avatar
        $avatar_check = avatar::where("user_id", Auth::user()->id)->take(1)->get();
        if(count($avatar_check) > 0){
            // delete file from the filesystem
               Storage::delete($avatar_check[0]->avatar);
            // update avatar table
            $avatar = avatar::find($avatar_check[0]->id);
            $avatar->forceDelete();
        }
        // create a new record
        $avatar = new avatar;
        $avatar->user_id = Auth::user()->id;
        $avatar->avatar = $filename;
        $avatar->filename = env("APP_URL")."/storage/avatars/".$filename; //file location
        $avatar->save();

        $store = $file->storeAs($dir, $filename, 'public');
        return redirect(route("me.profile"))->with("success", "Your avatar has been changed");
    }

    
    public function avatar(Request $request){
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
        ]);
        $dir = "avatars";
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->put("avatars/".Auth::user()->id, $image);
        $storagePath = env("APP_URL")."/storage//".$imagePath;
        // check if user has previously set an avatar
        $avatar_check = avatar::where("user_id", Auth::user()->id)->get();
        if(count($avatar_check) > 0){
            foreach ($avatar_check as $key => $myAvatar) {
                $avatar = avatar::find($myAvatar->id);
                // delete file from the filesystem
                Storage::disk('public')->delete($avatar->avatar);
                // update avatar table
                $avatar->forceDelete();
            }
        }
        // create a new record
        $avatar = new avatar;
        $avatar->user_id = Auth::user()->id;
        $avatar->avatar = $imagePath;
        $avatar->filename = $storagePath; //file location
        $avatar->save();

        return redirect(route("me.profile"))->with("success", "Your avatar has been changed");
    }

    public function error_access_denied(){
        return view("errors/access_denied");
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