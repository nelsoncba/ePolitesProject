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
	public function index()
	{
		$posts = Posts::selectAll();
        return Response::json($posts, 200);
	}

	/**
	 * Display a listing of the resource.
	 * GET /post
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function bySection($slug){
		$posts = Posts::bySection($slug);
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
			$post->usuario_id = '1';
			$post->imagen = Input::get('imgMini'); 
			$post->seccion_id = Input::get('section.id');
			$post->titulo = Input::get('title');
			$post->slug = Str::slug(Input::get('title'), '-');
			/*this condition will validate if the string $cuerpo going to saved with tags required <p> to display correctly in the view*/
			$post->cuerpo = preg_match('%(<p[^>]*>.*?</p>)%i', $cuerpo) ? $cuerpo : '<p>'.$cuerpo.'</p>';
			$post->urlFuente = Input::get('urlFuente');

			$oldTags = Tags::selectValues();
			$postTags = Input::get('tags');

			//iterate tag values to determinate if exists in D.B.
			foreach ($postTags as $postTag) {
				if(!in_array($postTag, $oldTags, true)){
					$tag = new Tags;
					$tag->tag = $postTag;
					$tag->slug = Str::slug($postTag);
					$tag->save();
				}
			}
	        //iterate to compare new tags with old tags and add to $tagsPost matching id´s 
			$tags = Tags::all();
			$tagsPost = array();
			foreach ($postTags as $pTag) {
				foreach ($tags as $tag) {
					if($pTag == $tag->tag){
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
			return Response::json('El artículo no existe', 403);
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
		//
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
		//
	}

	public function recentPosts(){
		$posts = Posts::getRecent();
		return Response::json($posts,200);
	}

}