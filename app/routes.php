<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('/api/allPosts', 'HomeController@getAllPosts');

Route::get('/api/recentPosts', 'HomeController@recentPosts');

Route::get('/api/post/{id}/{slug}', 'HomeController@getPost');

Route::post('/api/createPost', 'HomeController@createPost');

Route::post('/api/uploadImage', 'HomeController@uploadImage');

Route::get('/api/allSections', function(){
	$data = Secciones::getSections();
	return Response::json($data,200);
});

Route::get('/api/comments/{postId}', 'HomeController@getComments');

Route::post('/api/saveComment/{postId}', 'HomeController@saveComment');

Route::get('/api/replies/{commentId}', 'HomeController@getReplies');

Route::post('/api/saveReply/{commentId}', 'HomeController@postReply');