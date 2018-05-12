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
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//->middleware('auth');


Route::middleware(['auth'])->group(function () {

    Route::resource('companies', 'CompaniesController');

    Route::get('projects/create/{company_id?}', 'ProjectsController@create');
    Route::post('projects/adduser', 'ProjectsController@adduser')->name('projects.adduser');
    Route::get('projects/{id?}/staff', 'ProjectsController@staff')->name('projects.staff');
    Route::post('projects/add_staff', 'ProjectsController@addStaff');
    Route::get('project_staff_delete/{id}', 'ProjectsController@deleteProjectStaff');
    Route::get('projects/{id?}/tags', 'ProjectsController@tags')->name('projects.tags');
    Route::post('projects/add_tags', 'ProjectsController@addTags')->name('projects.addTags');
    Route::post('projects/{id?}/delete', 'ProjectsController@deleteProject')->name('projects.deleteProject');

    Route::resource('projects', 'ProjectsController');
    Route::resource('roles', 'RolesController');
    Route::resource('tasks', 'TasksController');
    Route::resource('users', 'UsersController');
    Route::resource('comments', 'CommentsController');
    Route::resource('staff', 'StaffController');
    Route::resource('tag', 'TagController');

    Route::namespace('Analysis')->group(function () {
        Route::get('statistics', 'GanttController@statistics')->name('statistics.index');
        Route::post('statistics', 'GanttController@statistics')->name('statistics.filter');
    });

    Route::namespace('Analysis')->group(function () {
        Route::resource('analysis', 'GanttController');
    });
});


