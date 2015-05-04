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

Route::get('/api/v1/allPosts/{page}/{perPage}', 'PostController@index');

Route::get('/api/v1/bySection/{slug}/{page}/{perPage}', 'PostController@bySection');

Route::get('/api/v1/recentPosts', 'PostController@recentPosts');

Route::get('/api/v1/post/{id}/{slug}', 'PostController@show');

Route::get('/api/v1/allSections', function(){
	$data = Secciones::getSections();
	return Response::json($data,200);
});

Route::get('/api/v1/comments/{postId}', 'CommentController@indexComment');

Route::get('/api/v1/replies/{commentId}', 'CommentController@indexReply');

Route::get('/api/v1/tags', function(){
	$tags = Tags::select('tag')->get();
	$tagList = array();
	foreach ($tags as $key => $value) {
		$tagList[] = $value->tag;
	}
	return Response::json($tags,200);
});

Route::post('/api/v1/register', 'RegisterController@store');

Route::post('/api/v1/authenticate', 'AuthenticationController@store');

Route::get('/api/v1/logout', 'AuthenticationController@index');

Route::get('/api/v1/register/verify/{confirmToken}', 'RegisterController@confirm');

Route::post('/api/v1/sendMail/{to}', 'AuthenticationController@sendMail');

Route::get('/api/v1/verifyResetPass/{token}', 'AuthenticationController@verifyResetPassword');

Route::post('/api/v1/resetPassword', 'AuthenticationController@resetPassword');

Route::group(array('before' => 'serviceAuth'), function(){
	Route::post('/api/v1/uploadImage/{id}', 'FilesController@uploadImage');
	Route::post('/api/v1/deleteImage', 'FilesController@destroyImage');
	Route::post('/api/v1/storePost', 'PostController@store');
	Route::put('/api/v1/updatePost/{id}', 'PostController@update');
	Route::delete('/api/v1/deletePost/{id}', 'PostController@destroy');
	Route::post('/api/v1/storeReply/{commentId}', 'CommentController@storeReply');
	Route::post('/api/v1/storeComment/{postId}', 'CommentController@storeComment');
	Route::get('/api/v1/likes/{id}/{likes}/{unlikes}', 'LikesController@store');
	Route::get('/api/v1/account/myPosts/{id}', 'AccountController@index');
});