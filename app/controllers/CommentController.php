<?php

class CommentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /comment
	 *
	 * @return Response
	 */
	public function indexComment($postId)
	{
		$comments = Comentarios::findComments($postId);
		return Response::json($comments, 200);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /comment/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /comment
	 *
	 * @return Response
	 */
	public function storeComment($postId)
	{
		$comment = new Comentarios;

		$comment->post_id = $postId;
		$comment->usuario_id = '2';
		$comment->comentario = Input::get('comment');

		if($comment->save()){
			$message = 'success';
		}

		return Response::json($message,200);
	}

	/**
	 * Display the specified resource.
	 * GET /comment/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /comment/{id}/edit
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
	 * PUT /comment/{id}
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
	 * DELETE /comment/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Display a listing of the resource.
	 * GET /reply
	 *
	 * @return Response
	 */
	public function indexReply($commentId)
	{
		$respuestas = Respuestas::with('Usuarios')->where('Respuestas.comentario_id','=', $commentId)->get();
		return Response::json($respuestas, 200);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /Reply
	 *
	 * @return Response
	 */
	public function storeReply($id)
	{
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