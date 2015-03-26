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
		$cuerpo = Input::get('content');
	
		$post->usuario_id = '1';
		$post->imagen = Input::get('image');;
		$post->seccion_id = Input::get('seccion.id');
		$post->titulo = Input::get('title');
		$post->slug = Str::slug(Input::get('title'), '-');
		$post->cuerpo = preg_match('%(<p[^>]*>.*?</p>)%i', $cuerpo) ? $cuerpo : '<p>'.$cuerpo.'</p>';

		
		$oldTags = Tags::selectValues();
		$postTags = explode(',', Input::get('tags'));

		//iterate values post to determinate if exists in D.B.
		foreach ($postTags as $postTag) {
			if(!in_array($postTag, $oldTags, true)){
				$tag = new Tags;
				$tag->tag = $postTag;
				$tag->slug = Str::slug($postTag);
				$tag->save();
			}
		}

		$tags = Tags::all();
		$tagsPost = array();
		foreach ($postTags as $pTag) {
			foreach ($tags as $tag) {
				if($pTag == $tag->tag){
					$tagsPost[] = $tag->id;
				}
			}
		}


		if($post->save()){
			$message = 'El artículo se a creado correctamente';
			$post->tags()->sync($tagsPost);
		}else{
			$message = 'Ha ocurrido un error';
		}

		return Response::json($message);
	}

	public function uploadImage(){
		$userId = 1;
		File::makeDirectory('images/temp/user'.$userId, 0777, true, true);
        $photo = Input::file('file');
        $photo->move('images/post/user'.$userId, $photo->getClientOriginalName());
        return Response::json('user'.$userId.'/'.$photo->getClientOriginalName(),200);
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
