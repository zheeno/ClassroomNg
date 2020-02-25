<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::GET('/', function () {
    return view('welcome');
});

// ******************************************
// ******************************************
// ******************************************

// guests are allowed in here
// courses group
Route::group(['prefix' => 'courses'], function(){
    // load courses index page
    Route::GET('/', [
        'uses' => 'CourseController@index',
        'as' => 'courses.index',
        'name' => 'Courses'
    ]);
    // load selected course page
    Route::GET('/{id}', [
        'uses' => 'CourseController@openCourse'
    ]);
});

// instructors group
Route::group(['prefix' => 'instructors'], function(){
    // load courses index page
    Route::GET('/', [
        'uses' => 'InstructorController@index',
        'as' => 'instructors'
    ]);
    // load selected course page
    Route::GET('/{id}', [
        'uses' => 'InstructorController@instructorPage'
    ]);
});

// search
Route::group(['prefix' => 'search'], function(){
    Route::GET('/courses', [
        'uses' => 'CourseController@searchCourses'
    ]);
    Route::GET('/classes', [
        'uses' => 'CourseController@searchClasses'
    ]);
    Route::GET('/instructors', [
        'uses' => 'InstructorController@searchInstructors'
    ]);
});

// classes group
Route::group(['prefix' => 'classes'], function(){
    // load selected class page
    Route::GET('/{id}', [
        'uses' => 'ClassesController@openClass'
    ]);
});

// instructors group
Route::group(['prefix' => 'educateMe'], function(){
    // load courses index page
    Route::GET('/', [
        'uses' => 'CourseController@educateMe',
        'as' => 'educate'
    ]);
});
// ******************************************
// ******************************************
// ******************************************
// ******************************************

// only authenticated users are allowed in here
Route::group(['middleware' => 'auth'], function(){ //grouping routes such that only authenticated users can access them
    // route to profile
    Route::GET('/profile', [
        'uses' => 'HomeController@myProfile',
        'as' => 'me.profile'
    ]);
    // update profile
    Route::POST('/profile', [
        'uses' => 'HomeController@updateProfile',
        'as' => 'update.profile'
    ]);
    // upload avatar
    Route::POST('/uploadAvatar', [
        'uses' => 'HomeController@avatar',
        'as' => 'upload.avatar'
    ]);
    // delete attachment
    Route::GET('/attachment/delete/{id}', [
        'uses' => 'ClassesController@deleteAttachment',
    ]);
    // courses group
    Route::group(['prefix' => 'courses'], function(){
        // toggle course subscription
        Route::GET('/{id}/togSubscription', [
            'uses' => 'CourseController@togCourseSubscription'
        ]);
    });

    // classes group
    Route::group(['prefix' => 'classes'], function(){
        // delete class
        Route::GET('/{id}/delete', [
            'uses' => 'ClassesController@deleteClass'
        ]);
        Route::GET('/{id}/{route}/delete', [
            'uses' => 'ClassesController@deleteClass'
        ]);
    });

    // Instructors group
    Route::group(['prefix' => 'instructors'], function(){
        // toggle instructor follow
        Route::GET('/{id}/togFollow', [
            'uses' => 'InstructorController@togInstructorFollow'
        ]);
    });

    // classes group
    Route::group(['prefix' => 'classes'], function(){
        // load selected class page
        Route::POST('/addComment', [
            'uses' => 'ClassesController@addComment',
            'as' => 'classes.addComment'
        ]);
        // add class
        Route::POST('/addClass', [
            'uses' => 'ClassesController@addClass',
            'as' => 'classes.addClass'
        ]);
        // edit class
        Route::GET('/{id}/editClass', [
            'uses' => 'ClassesController@editClass'
        ]);
        // update class
        Route::POST('/updateClass', [
            'uses' => 'ClassesController@updateClass',
            'as' => 'classes.updateClass'
        ]);
        Route::POST('/uploadFile', [
            'uses' => 'ClassesController@uploadFile'
        ]);
    });

    // student middleware
    // restricts this section of the site to only students
    Route::group(['middleware' => 'student'], function(){ //grouping routes such that only authenticated users can access them
        Route::group(['prefix' => 'student'], function(){
            // opens students'dashboard page
            Route::GET('/',[
                'uses' => 'StudentController@dashboard',
                'as' => 'student.dashboard'
            ]);
            // users with administrative previledges
            Route::GET('/overview', [
                'uses' => 'StudentController@overview',
                'as' => 'console.overview'
            ]);
        });
    });
    // instructor middleware
    Route::group(['middleware' => 'instructor'], function(){ //grouping routes such that only authenticated users can access them
        // instructors group
        Route::group(['prefix' => 'instructor'], function(){
            // load courses index page
            Route::GET('/', [
                'uses' => 'InstructorController@dashboard',
                'as' => 'instructor.dashboard'
            ]);
            // add class
            Route::GET('/addClass', [
                'uses' => 'InstructorController@addClass',
                'as' => 'instructor.addClass'
            ]);
            // fetch notifs
            Route::GET('/showClassesNotifs', [
                'uses' => 'InstructorController@showClassesNotifs'
            ]);
        });
    });
    // moderator middleware
    // restricts this section of the site to only moderators
    Route::group(['middleware' => 'moderator',/* 'middleware' => 'admin'*/], function(){ //grouping routes such that only authenticated users can access them
        Route::group(['prefix' => 'moderator'], function(){
            // opens moderators'dashboard page
            Route::GET('/',[
                'uses' => 'ModeratorController@dashboard',
                'as' => 'moderator.dashboard'
            ]);
            Route::GET('/course/{id}',[
                'uses' => 'ModeratorController@reviewCourse',
                'as' => 'moderator.review'
            ]);
            Route::POST('/addReview',[
                'uses' => 'ModeratorController@addReview',
                'as' => 'moderator.addReview'
            ]);
        });
    });
    // administrator middleware
    Route::group(['middleware' => 'admin'], function(){ //grouping routes such that only authenticated users can access them
        Route::group(['prefix' => 'admin'], function(){
            // opens admins' dashboard page
            Route::GET('/',[
                'uses' => 'AdministratorController@dashboard',
                'as' => 'admin.dashboard'
            ]);
            // route to view courses
            Route::GET('/viewCourses',[
                'uses' => 'AdministratorController@viewCourses',
                'as' => 'admin.viewCourses'
            ]);
            Route::POST('/addReview',[
                'uses' => 'ModeratorController@addReview',
                'as' => 'admin.addReview'
            ]);
            // route to view selected course
            Route::GET('/viewCourses/{id}',[
                'uses' => 'AdministratorController@viewThisCourse'
            ]);
            // route to edit selected course
            Route::GET('/viewCourses/{id}/edit',[
                'uses' => 'AdministratorController@editThisCourse'
            ]);
            // route to add course 
            Route::GET('/addCourse',[
                'uses' => 'AdministratorController@addCourse',
                'as' => 'admin.addCourse'
            ]);
            // route to update course 
            Route::POST('/updateCourse',[
                'uses' => 'AdministratorController@updateCourse',
                'as' => 'admin.updateCourse'
            ]);
            // revoke review previledge from moderator
            Route::GET('/courses/{course_id}/{mod_id}/revokeRevPrv',[
                'uses' => 'AdministratorController@revokeRevPrv',
                'as' => 'admin.revokeRevPrv'
            ]);
            // delete course
            Route::GET('/courses/{course_id}/deleteCourse',[
                'uses' => 'AdministratorController@deleteCourse',
                'as' => 'admin.deleteCourse'
            ]);
            // handle add course form submission
            Route::POST('/addCourse',[
                'uses' => 'AdministratorController@postNewCourse',
                'as' => 'admin.postNewCourse'
            ]);
            Route::POST('/course/addModerator',[
                'uses' => 'AdministratorController@addModerator',
                'as' => 'admin.addModerator'
            ]);
            Route::group(['prefix' => 'search'], function(){
                Route::GET('/users',[
                    'uses' => 'AdministratorController@searchUsers',
                    'as' => 'admin.searchUsers'
                ]);
                Route::GET('/courses',[
                    'uses' => 'AdministratorController@searchCourses',
                    'as' => 'admin.searchCourses'
                ]);
            });
            Route::group(['prefix' => 'users'], function(){
                // route to view courses
                Route::GET('/',[
                    'uses' => 'AdministratorController@allUsers',
                    'as' => 'admin.allUsers'
                ]);
                Route::GET('/{id}',[
                    'uses' => 'AdministratorController@viewUser',
                ]);
                // delete user account
                Route::GET('/{id}/deleteUser',[
                    'uses' => 'AdministratorController@deleteUser',
                ]);
                Route::GET('/{perm}/get',[
                    'uses' => 'AdministratorController@fetchUsers',
                    'as' => 'admin.fetchUsers'
                ]);
                Route::POST('/changePerm',[
                    'uses' => 'AdministratorController@changePerm',
                    'as' => 'admin.changePerm'
                ]);
            });
        });
    });
    // end of auth middleware
});
// errors
Route::group(['prefix' => 'error'], function(){
    Route::GET('/404', [
        'uses' => 'HomeController@error_404',
        'as' => 'errors.404'
    ]);
    Route::GET('/access_denied', [
        'uses' => 'HomeController@error_access_denied',
        'as' => 'errors.access_denied'
    ]);
});

Auth::routes();

Route::GET('/home', 'HomeController@index')->name('home');

Route::GET('/refundPolicy', [
    'uses' => 'CourseController@refundPolicy',
    'as' => 'home.access_denied'
]);