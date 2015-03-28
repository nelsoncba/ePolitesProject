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

Route::post('/api/createPost', 'PostController@store');

Route::post('/api/uploadImage', 'FilesController@uploadImage');

Route::get('/api/allSections', function(){
	$data = Secciones::getSections();
	return Response::json($data,200);
});

Route::get('/api/comments/{postId}', 'CommentController@indexComment');

Route::post('/api/saveComment/{postId}', 'CommentController@storeComment');

Route::get('/api/replies/{commentId}', 'CommentController@indexReply');

Route::post('/api/saveReply/{commentId}', 'CommentController@storeReply');

Route::get('/api/tags', function(){
	$tags = Tags::select('tag')->get();
	$tagList = array();
	foreach ($tags as $key => $value) {
		$tagList[] = $value->tag;
	}
	return Response::json($tagList,200);
});