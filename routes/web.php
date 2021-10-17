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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//User profile
Route::get('profile/{username}', '\App\Http\Controllers\ProfileController@search_user');

Route::group(['middleware' => 'auth'], function (){
    Route::get('/feed', [\App\Http\Controllers\FeedController::class, 'index']);
    Route::post('add-post', '\App\Http\Controllers\FeedController@add_post');
    Route::post('add-comment', '\App\Http\Controllers\FeedController@add_comment');
    Route::get('like/{id}', '\App\Http\Controllers\FeedController@like');
    Route::get('follow/{following}', '\App\Http\Controllers\ProfileController@follow_user');


    Route::get('settings', '\App\Http\Controllers\ProfileController@settings');
    Route::post('update-profile', '\App\Http\Controllers\ProfileController@update');

});

require __DIR__.'/auth.php';
