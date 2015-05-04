<?php

class LikesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /likes
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /likes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /likes
	 *
	 * @return Response
	 */
	public function store($id, $likes ,$unlikes)
	{
		$user_id = Auth::id();
		$like = Likes::where('comentario_id','=',$id)->first();

		if($like != null){
			
			if(strstr($like['usuarios'], $user_id."|")== true){
				return Response::json(array('likes'=>$likes,'unlikes'=>$unlikes),403);
			}
			else{
				$newCount = $like->usuarios."".$user_id."|";
				if($likes == true){
					$like->likes = $like->likes + $likes;
				}
				if($unlikes == true){
					$like->unlikes = $like->unlikes + $unlikes;
				}
				$like->usuarios = $newCount;
				$like->save();

				return Response::json(array('likes'=> $like->likes, 'unlikes'=>$like->unlikes),200);
			}
		}else{
			$newLike = new likes;

			$newLike->comentario_id = $id;
			if($likes == true){
				$newLike->likes = $newLike->likes + 1;
				$newLike->usuarios = $user_id."|";
				$newLike->save();
				return Response::json(array('likes'=>$newLike->likes,'unlikes'=>$newLike->unLikes),200);
			}
			if($unlikes == true){
				$newLike->unlikes = $newLike->unlikes + 1;
				$newLike->usuarios = $user_id."|";
				$newLike->save();
				return Response::json(array('likes'=>$newLike->likes,'unlikes'=>$newLike->unlikes),200);
			} 
		}
	}

	/**
	 * Display the specified resource.
	 * GET /likes/{id}
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
	 * GET /likes/{id}/edit
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
	 * PUT /likes/{id}
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
	 * DELETE /likes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}