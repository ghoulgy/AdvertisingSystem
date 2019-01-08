<?php

use Illuminate\Support\Facades\Redis;
use App\Events\MessagePosted;
use App\Events\MarkerPosted;
use App\Events\NotificationStatus;
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

Route::get('/messages', function() {
	return App\Message::with('user')->get();
});

Route::post('/messages', function() {
	$user = Auth::user();

	$message = $user->messages()->create([
		'message' => request()->get('message')
	]);

	broadcast(new MessagePosted($message, $user))->toOthers();

	return ['status' => "OK"];
})->middleware('auth');

Route::get('/noti', function () {
    return view('noti');
})->name('noti');

Route::post('/dpost', 'PostController@store');

Route::post('/postMarker', function() {
	$user = Auth::user();

	$marker = $user->markers()->create([
		'lng' => request()->get('lng'),
		'lat' => request()->get('lat'),
		'title' =>request()->get('title'),
		'type' => request()->get('type'),
		'description' => request()->get('description')
	]);

	// $position = request()->get('position');
	broadcast(new MarkerPosted($marker))->toOthers();

	return ['status' => "OK"];
});

Route::get('/markers', function() {
	return App\Marker::with('user')->get(['lng','lat', 'title', 'type','description', 'user_id']);
});

Route::post('/postDemandMarker', function() {
	$user = Auth::user();

	$markerDemand = $user->markersdemand()->create([
		'lng' => request()->get('lng'),
		'lat' => request()->get('lat'),
		'title' => request()->get('title'),
		'type' => request()->get('type'),
		'need' => request()->get('need'),
		'description' => request()->get('description')
	]);

	// $position = request()->get('position');
	broadcast(new MarkerPosted($markerDemand))->toOthers();

	return ['status' => "OK"];
});

Route::get('/markersDemand', function() {
	return App\MarkerDemand::with('user')->get(['lng','lat', 'title', 'type', 'need', 'description', 'user_id']);
});

// Route::get('/markAsRead',function(){
//     auth()->user()->unreadNotifications->markAsRead();
// });

//Get user id
Route::get('/user', function() {
	return Auth::user()->id;
});

// Get profile picture
Route::get('profile', 'UserController@profile');
Route::post('profile', 'UserController@update_avatar');

// Notification notice
Route::post('/test', function () {
	$user = Auth::user();

    broadcast(new NotificationStatus($user))->toOthers();
    return "Event has been sent!";
});

Route::post('/api/requests/to/{user}', 'RequestController@createRequest');
// Route::get('/api/self', function() {
//     return Auth::user();
// });