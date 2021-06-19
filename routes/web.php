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


Route::resource('post', 'PostController')->only('index', 'store');


Route::resource('post', 'PostController')->only('index', 'store');
Route::get('users', 'App\Http\Controllers\UserChartController@index');
Route::get('/check','App\Http\Controllers\sample@index');
Route::get('/echarts', 'App\Http\Controllers\EchartController@echart');
Route::get('/map', 'App\Http\Controllers\CompaniesController@index');
Route::get('/students', [App\Http\Controllers\StudentController::class, 'index']);
Route::get('/students/list', [App\Http\Controllers\StudentController::class, 'getStudents'])->name('students.list');
