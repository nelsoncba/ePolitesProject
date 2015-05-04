<?php

class FilesController extends \BaseController {

	/**
     * function to create a images directory and upload images by users  
     */
	public function uploadImage($userId){
		File::makeDirectory('images/post/user'.$userId, 0777, true, true);
        $photo = Input::file('file');
        $photo->move('images/post/user'.$userId, $photo->getClientOriginalName());
        return Response::json('user'.$userId.'/'.$photo->getClientOriginalName(),200);
	}

	public function destroyImage(){
		 
		$path = Input::get('imagemini');
		if(File::exists($path)){
			File::delete($path);
		}else{
			return Response::json($image,403);
		} 
		return Response::json('Mini-imagen eliminada de servidor',200);
	}
}