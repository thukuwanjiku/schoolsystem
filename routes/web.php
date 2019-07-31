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
        Route::get('/', 'StaffController@index')->name('users');
        Route::post('/add', 'StaffController@add')->name('users_add');
        Route::post('/update', 'StaffController@update')->name('users_update');
        Route::post('/delete', 'StaffController@delete')->name('users_delete');
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

        Route::group([
            'prefix' => "class-teachers",
        ], function(){
            Route::post('/assign', 'ClassTeachersController@assign')->name('class-teacher_assign');
            Route::post('/update', 'ClassTeachersController@update')->name('class-teacher_update');
            Route::post('/delete', 'ClassTeachersController@delete')->name('class-teacher_delete');
        });

    });

    Route::group([
        'prefix' => 'chat',
        'namespace' => 'Chat'
    ], function(){
        Route::get('/', 'AdminChatController@index')->name('admin_chat');
        Route::post('/send-msg', 'AdminChatController@sendMsg')->name('admin_send_msg');
        Route::post('/send-chat-msg', 'AdminChatController@sendChatMsg')->name('admin_send_chat_msg');
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
    Route::get('/register-today', 'StudentRegisterController@registerToday')->name('register_today');
    Route::post('/update-register-today', 'StudentRegisterController@updateRegisterToday')->name('register_today_update');

});

Route::group([
    'prefix' => 'medical',
    'namespace' => 'Medical',
    'middleware' => ['auth']
], function(){

    Route::get('/', 'MedicalController@index')->name('medical');
    Route::get('/new-medical-report', 'MedicalController@newMedicalReport')->name('new_medical');
    Route::post('/new-medical-report', 'MedicalController@saveMedicalReport')->name('save_new_medical');

});

Route::group([
    'prefix' => 'discipline',
    'namespace' => 'Discipline',
    'middleware' => ['auth']
], function(){

    Route::get('/', 'DisciplineController@index')->name('discipline');
    Route::get('/new-indiscipline-case', 'DisciplineController@newIndisciplineCase')->name('new_discipline_case');
    Route::post('/new-indiscipline-case', 'DisciplineController@saveDisciplineCase')->name('save_new_discipline_case');

});

Route::group([
    'prefix' => "parents",
    'namespace' => "Parents"
], function(){

    Route::get('/login', 'ParentsLoginController@showLogin')->name('parents_login');
    Route::post('/login', 'ParentsLoginController@login')->name('parents_login_post');

    Route::group([
        'middleware' => ['parents_access']
    ], function(){

        Route::post('/logout', 'ParentsLoginController@logout')->name('parents_logout');
        Route::get('/dashboard', 'ParentsDashboardController@index')->name('parents_dashboard');


        Route::get('/performance', 'ParentsPerformanceController@index')->name('parents_performance');
        Route::get('/student-welfare', 'StudentWelfareController@index')->name('parents_student_welfare');

        Route::get('chat', 'ParentsChatController@index')->name('parents_chat');
        Route::post('send-msg', 'ParentsChatController@sendMsg')->name('parents_send_msg');

    });

});