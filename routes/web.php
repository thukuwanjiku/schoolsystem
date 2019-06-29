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

Route::get('/', function () {
    //return view('welcome');
    return redirect(url('login'));
});



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth']
], function(){

    Route::get('/student-groups', 'StudentGroupsController@index')->name('groups');
    Route::post('/student-groups/add', 'StudentGroupsController@add');
    Route::post('/student-groups/update', 'StudentGroupsController@update');
    Route::post('/student-groups/delete', 'StudentGroupsController@delete');

    Route::group([
        'namespace' => 'Students',
        'prefix' => 'students'
    ], function (){
        Route::get('/', 'StudentsController@index')->name('students');
        Route::post('/add', 'StudentsController@add')->name('students_add');
        Route::post('/update', 'StudentsController@update')->name('students_update');
        Route::post('/delete', 'StudentsController@delete')->name('students_delete');
    });

    Route::group([
        'namespace' => 'Users',
        'prefix' => 'users'
    ], function (){
        Route::get('/', 'UsersController@index')->name('users');
        Route::post('/add', 'UsersController@add')->name('users_add');
        Route::post('/update', 'UsersController@update')->name('users_update');
        Route::post('/delete', 'UsersController@delete')->name('users_delete');
    });

    Route::group([
        'prefix' => "academics",
        'namespace' => 'Academics'
    ], function(){

        Route::get('/', 'AcademicsController@index')->name('academics');

        Route::group([
            'prefix' => "subjects",
        ], function(){
            Route::post('/add', 'SubjectsController@add')->name('subjects_add');
            Route::post('/update', 'SubjectsController@update')->name('subjects_update');
            Route::post('/delete', 'SubjectsController@delete')->name('subjects_delete');
        });

        Route::group([
            'prefix' => "exams",
        ], function(){
            Route::post('/add', 'ExamsController@add')->name('exams_add');
            Route::post('/update', 'ExamsController@update')->name('exams_update');
            Route::post('/change-status', 'ExamsController@changeStatus')->name('exams_change-status');
        });

        Route::group([
            'prefix' => "subjects-allocation",
        ], function(){
            Route::post('/allocate', 'SubjectsAllocationController@allocate')->name('subjects-allocation_allocate');
            Route::post('/update', 'SubjectsAllocationController@update')->name('subjects-allocation_update');
        });

    });

});

Route::group([
    'prefix' => 'teacher',
    'namespace' => 'Teacher',
    'middleware' => ['auth']
], function(){

    Route::get('/exam-marks', 'ExamMarksController@index')->name('exam_marks');
    Route::post('/exam-marks-entry-selections', 'ExamMarksController@acceptSelections')->name('exam_marks-entry-selections');
    Route::post('/save-exam-marks', 'ExamMarksController@saveMarks')->name('exam_save_marks');

    Route::get('/register', 'StudentRegisterController@index')->name('register');
    Route::post('/search-register', 'StudentRegisterController@searchRegister')->name('search_register');

});