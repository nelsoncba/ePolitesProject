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

Route::get('/api/allPosts', 'PostController@index');

Route::get('/api/recentPosts', 'PostController@recentPosts');

Route::get('/api/post/{id}/{slug}', 'PostController@show');

Route::post('/api/storePost', 'PostController@store');

Route::post('/api/uploadImage', 'FilesController@uploadImage');

Route::get('/api/allSections', function(){
	$data = Secciones::getSections();
	return Response::json($data,200);
});

Route::get('/api/comments/{postId}', 'CommentController@indexComment');

Route::post('/api/storeComment/{postId}', 'CommentController@storeComment');

Route::get('/api/replies/{commentId}', 'CommentController@indexReply');

Route::post('/api/storeReply/{commentId}', 'CommentController@storeReply');

Route::get('/api/tags', function(){
	$tags = Tags::select('tag')->get();
	$tagList = array();
	foreach ($tags as $key => $value) {
		$tagList[] = $value->tag;
	}
	return Response::json($tagList,200);
});