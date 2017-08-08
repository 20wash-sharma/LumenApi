<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/teachers', 'TeacherController@index');
$app->post('/teachers', 'TeacherController@store');
$app->get('/teachers/{id}', 'TeacherController@show');
$app->put('/teachers/{id}', 'TeacherController@update');
$app->patch('/teachers/{id}', 'TeacherController@update');
$app->delete('/teachers/{id}', 'TeacherController@destroy');

$app->get('/students', 'StudentController@index');
$app->post('/students', 'StudentController@store');
$app->get('/students/{id}', 'StudentController@show');
$app->put('/students/{id}', 'StudentController@update');
$app->patch('/students/{id}', 'StudentController@update');
$app->delete('/students/{id}', 'StudentController@destroy');

$app->get('/courses', 'CourseController@index');
$app->get('/courses/{id}', 'CourseController@show');

$app->get('/teachers/{id}/courses', 'TeacherCourseController@index');
$app->post('/teachers/{id}/courses', 'TeacherCourseController@store');
$app->put('/teachers/{teacherid}/courses/{courseid}', 'TeacherCourseController@update');
$app->patch('/teachers/{teacherid}/courses/{courseid}', 'TeacherCourseController@update');
$app->delete('/teachers/{teacherid}/courses/{courseid}', 'TeacherCourseController@destroy');


$app->get('/courses/{id}/students', 'CourseStudentController@index');
$app->post('/courses/{courseid}/students/{studentid}', 'CourseStudentController@store');
$app->delete('/courses/{courseid}/students/{studentid}', 'CourseStudentController@destroy');
$app->post('/oauth/access_token',function(){
   return response()->json(Authorizer::issueAccessToken()); 
});

/*$app->post('/oauth/access_token',function () use ($app){
   return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken()); 
});*/

