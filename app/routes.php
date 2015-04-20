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

Route::get('/api/allPosts/{page}/{perPage}', 'PostController@index');

Route::get('/api/bySection/{slug}/{page}/{perPage}', 'PostController@bySection');

Route::get('/api/recentPosts', 'PostController@recentPosts');

Route::get('/api/post/{id}/{slug}', 'PostController@show');

Route::post('/api/uploadImage', 'FilesController@uploadImage');

Route::post('/api/deleteImage', 'FilesController@destroyImage');

Route::get('/api/allSections', function(){
	$data = Secciones::getSections();
	return Response::json($data,200);
});

Route::get('/api/comments/{postId}', 'CommentController@indexComment');



Route::get('/api/replies/{commentId}', 'CommentController@indexReply');

Route::get('/api/tags', function(){
	$tags = Tags::select('tag')->get();
	$tagList = array();
	foreach ($tags as $key => $value) {
		$tagList[] = $value->tag;
	}
	return Response::json($tagList,200);
});

Route::post('/api/authenticate', 'AuthenticationController@store');

Route::get('/api/logout', 'AuthenticationController@index');

Route::group(array('before' => 'serviceAuth'), function(){
	Route::post('/api/storePost', 'PostController@store');
	Route::post('/api/storeReply/{commentId}', 'CommentController@storeReply');
	Route::post('/api/storeComment/{postId}', 'CommentController@storeComment');
});