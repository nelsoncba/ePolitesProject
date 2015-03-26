<?php

class PostController extends \BaseController {

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
		$post = new Posts;
		$post->usuario_id = '1';
		$post->imagen = Input::get('image');;
		$post->seccion_id = Input::get('seccion.id');
		$post->titulo = Input::get('title');
		$post->slug = Str::slug(Input::get('title'), '-');
		$post->cuerpo = Input::get('content');

		$tagsSave[] = '';
		$newTags[] = '';
		$oldTags = Tags::all();
		$postTags = explode(',',Input::get('tags'));
		foreach ($oldTags as $oldTag) {
			foreach ($postTags as $postTag) {
				if($oldTag->tag == $postTag){
					$tagsSave[] = $oldTag->id;
				}else{
					$newTags[] = $postTag;
				}
			}
		}
		$tag = new Tags; 
		foreach ($newTags as $newTag) {
			$tag->tag = $newTag;
			$tagsSave[] = Tags::where('tag','=', $newTag)->get('id');
		}
		$post->tags()->sync($tagsSave);


		if($post->save()){
			$message = 'El artículo se a creado correctamente';
		}else{
			$message = 'Ha ocurrido un error';
		}
		return Response::json($message);
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
		return Response::json($post, 200);
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