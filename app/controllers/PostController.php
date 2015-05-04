<?php

class PostController extends \BaseController {

	public function __construct(){
		//$this->beforeFilter('serviceAuth', ['except' => ['index', 'show', 'bySection', 'recentPosts']]);
	}

	/**
	 * Display a listing of the resource.
	 * GET /post
	 *
	 * @return Response
	 */
	public function index($page, $perPage)
	{	
		Paginator::setCurrentPage($page);
		$posts = Posts::selectAll($perPage);
		
        return Response::json($posts, 200);
	}

	/**
	 * Display a listing of the resource.
	 * GET /post
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function bySection($slug, $page, $perPage){
		Paginator::setCurrentPage($page);
		$posts = Posts::bySection($slug, $perPage);
		return Response::json($posts, 200);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /post/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /post
	 *
	 * @return Response
	 */
	public function store()
	{	
		$validator = Validator::make(Input::all(), Posts::$rules);
		if($validator->fails()){
			return Response::json($validator->messages(),403);
		}
		else{
			$post = new Posts;
			$cuerpo = Input::get('content');
			$post->usuario_id = Auth::id();
			$post->imagen = Input::get('imgMini'); 
			$post->seccion_id = Input::get('section.id');
			$post->titulo = Input::get('title');
			$post->slug = Str::slug(Input::get('title'), '-');
			$post->estado = true;
			/*this condition will validate if the string $cuerpo going to saved with tags required <p> to display correctly in the view*/
			$post->cuerpo = preg_match('%(<p[^>]*>.*?</p>)%i', $cuerpo) ? $cuerpo : '<p>'.$cuerpo.'</p>';
			$post->urlFuente = Input::get('urlFuente');

			$oldTags = Tags::selectValues();
			$getTags = Input::get('tags');
			$postTags = [];
			foreach ($getTags as  $val) {
				foreach ($val as $key => $value) {
					$postTags[] = $value;
				}
			 } 
			 
			//iterate tag values to determinate if exists in D.B. and save the news tags
			foreach ($postTags as $postTag => $value) {
				if(!in_array($value, $oldTags, true)){
					$tag = new Tags;
					$tag->tag = $value;
					$tag->slug = Str::slug($value);
					//$tag->save();
				}
			}
	        //iterate to compare new tags with old tags and add to $tagsPost matching id´s 
			$tags = Tags::all();
			$tagsPost = array();
			foreach ($postTags as $key => $value) {
				foreach ($tags as $tag) {
					if($value == $tag->tag){
						$tagsPost[] = $tag->id;
					}
				}
			}

			//This is the condition to send success message or error message after save the new post and syncronize the matching $tagsPost 
			// in the intermediate table Tags_Posts
			if($post->save()){
				$message = array('success'=>'El artículo se a creado exitosamente.');
				$post->tags()->sync($tagsPost);
				return Response::json($message,200);
			}else{
				$message = array('error'=>'Ha ocurrido un error al intentar crear el artículo.');
				return Response::json($message,403);
			}
		}
	}

	/**
	 * Display the specified resource.
	 * GET /post/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$post = Posts::getPost($id);
		if($post){
			return Response::json($post, 200);
		}else{
			return Response::json(array('message'=>'El artículo no existe'), 403);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /post/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /post/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator = Validator::make(Input::all(), Posts::$rules);
		if($validator->fails()){
			return Response::json($validator->messages(),403);
		}
		else{
			$post = Posts::find($id);
			$cuerpo = Input::get('content');
			$post->imagen = Input::get('imgMini');
			Input::get('section') ? $post->seccion_id = Input::get('section.id') : '';
			$post->titulo = Input::get('title');
			$post->slug = Str::slug(Input::get('title'), '-');
			/*this condition will validate if the string $cuerpo going to saved with tags required <p> to display correctly in the view*/
			$post->cuerpo = preg_match('%(<p[^>]*>.*?</p>)%i', $cuerpo) ? $cuerpo : '<p>'.$cuerpo.'</p>';
			$post->urlFuente = Input::get('urlFuente');

			$oldTags = Tags::selectValues();
			$getTags = Input::get('tags');
			$postTags = [];
			foreach ($getTags as  $val) {
				foreach ($val as $key => $value) {
					$postTags[] = $value;
				}
			 } 
			 
			//iterate tag values to determinate if exists in D.B. and save the news tags
			foreach ($postTags as $postTag => $value) {
				if(!in_array($value, $oldTags, true)){
					$tag = new Tags;
					$tag->tag = $value;
					$tag->slug = Str::slug($value);
					//$tag->save();
				}
			}
	        //iterate to compare new tags with old tags and add to $tagsPost matching id´s 
			$tags = Tags::all();
			$tagsPost = array();
			foreach ($postTags as $key => $value) {
				foreach ($tags as $tag) {
					if($value == $tag->tag){
						$tagsPost[] = $tag->id;
					}
				}
			}

			//This is the condition to send success message or error message after save the new post and syncronize the matching $tagsPost 
			// in the intermediate table Tags_Posts
			if($post->save()){
				$message = array('success'=>'El artículo se a guardado exitosamente.');
				$post->tags()->sync($tagsPost);
				return Response::json($message,200);
			}else{
				$message = array('error'=>'Ha ocurrido un error al intentar guardar el artículo.');
				return Response::json($message,403);
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /post/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{		
		$post = Posts::where('id','=', $id)->first();
		$comentarios = Comentarios::where('post_id','=', $id)->select('id')->get();
		$img_path = $post->imagen;

		
		try {
			
			foreach ($comentarios as $comentario) {
				Respuestas::where('comentario_id','=',$comentario->id)->delete();
				Likes::where('comentario_id','=', $comentario->id);
			}
			Comentarios::where('post_id','=', $id)->delete();
			Posts_Tags::where('post_id','=', $id)->delete();
			if(File::exists($img_path)){
				File::delete($img_path);
			}
			$post->delete();
			return Response::json(array('message' => 'El artículo se ha eliminado correctamente'),200);
		 	
		 } catch (Exception $e) {
		 	return Response::json(array('message' => 'Error al eliminar artículo: '),403);
		 } 
	}

	public function recentPosts(){
		$posts = Posts::getRecent();
		return Response::json($posts,200);
	}

}