<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['auth:sanctum', 'verified'],function(){
    Route::get('/courses','App\Http\Controllers\CourseController@index')->name('courses');
    Route::get('/course/{id}','App\Http\Controllers\CourseController@show')->name('course.show');
    Route::post('/toogleProgress','App\Http\Controllers\CourseController@toogleEpisode')->name('course.termine.episode');
    Route::post('/formations','App\Http\Controllers\CourseController@saveFormations');
    Route::get("/courses/edit/{id}",'App\Http\Controllers\CourseController@edit')->name("edit_course");
    Route::patch("/courses/{id}",'App\Http\Controllers\CourseController@update')->name("update_course");
});
