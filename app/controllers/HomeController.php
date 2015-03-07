<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	
	public function showWelcome()
	{
		return View::make('hello');
	}

	public function getAllPosts(){

        $posts = Posts::selectAll();
        return Response::json($posts, 200);
	}

	public function recentPosts(){
		$posts = Posts::getRecent();
		return Response::json($posts,200);
	}

	public function getPost($id){
		$post = Posts::getPost($id);
		return Response::json($post, 200);
	}

	public function createPost(){
		$post = new Posts;
		$text = '<p>'.Input::get('content').'</p>';
		$post->usuario_id = '1';
		$post->seccion_id ='1';
		$post->titulo = Input::get('title');
		$post->slug = Str::slug(Input::get('title'), '-');
		$post->cuerpo = $text;

		if($post->save()){
			$message = 'El artículo se a creado correctamente';
		}else{
			$message = 'Ha ocurrido un error';
		}
		return Response::json($message);
	}

	public function uploadImage(){
		$photo = Input::file('file')->getClientOriginalName();
	}

	public function getComments($postId){
		$comments = Comentarios::findComments($postId);
		return Response::json($comments, 200);
	}

	public function saveComment($postId){
		$comment = new Comentarios;

		$comment->post_id = $postId;
		$comment->usuario_id = '2';
		$comment->comentario = Input::get('comment');

		if($comment->save()){
			$message = 'success';
		}

		return Response::json($message,200);
	}

	public function getReplies($commentId){
		$respuestas = Respuestas::with('Usuarios')->where('Respuestas.comentario_id','=', $commentId)->get();
		return Response::json($respuestas, 200);
	}

	public function postReply($id){

		$reply = new Respuestas;

		$reply->respuesta = Input::get('reply');
		$reply->comentario_id = $id;
		$reply->usuario_id = '1';

		if($reply->save()){
			$message = 'success';
		}else{
			$message = 'error';
		}
		return Response::json($message,200);
	}

}
