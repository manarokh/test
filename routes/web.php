<?php

// \App\Project::created( function($project) {
//     \App\Activity::create([
//         'project_id' => $project->id,
//         'description' => 'created'
//     ]);
// });

// \App\Project::updated( function($project) {
//     \App\Activity::create([
//         'project_id' => $project->id,
//         'description' => 'updated'
//     ]);
// });

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

Route::group(['middleware' => 'auth'], function () {
    // Route::post('/projects', 'ProjectsController@store');
    // Route::get('/projects', 'ProjectsController@index');
    // Route::get('/projects/create', 'ProjectsController@create');        
    // Route::get('/projects/{project}/edit', 'ProjectsController@edit');        
    // Route::get('/projects/{project}', 'ProjectsController@show');        
    // Route::patch('/projects/{project}', 'ProjectsController@update');
    // Route::delete('/projects/{project}', 'ProjectsController@destroy');
    //project Routes
    Route::resource('projects', 'ProjectsController');
    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store');

    //Tasks Routes
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');
    Route::get('/projects/{project}/tasks/{task}', 'ProjectTasksController@edit');
    Route::delete('/projects/{project}/tasks/{task}', 'ProjectTasksController@destroy');
    Route::get('/projects/{project}/tasks/{task}/test', 'ProjectTasksController@test');
    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::get('/projects/{project}/create_task', 'ProjectTasksController@show');
    Route::post('/projects/{project}/create_task', 'ProjectTasksController@store');

    //Bills Routes
    // Route::get('/bill/{bill}', 'BillsTasksController@index');
    // Route::get('/projects/{project}/tasks/{task}/bills', 'BillsTasksController@show');

    //default Route
    Route::get('/home', 'ProjectsController@index')->name('home');
});

Auth::routes();

