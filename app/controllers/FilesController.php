<?php

class FilesController extends \BaseController {

	/**
     * function to create a images directory and upload images by users  
     */
	public function uploadImage(){
		$userId = 1;
		File::makeDirectory('images/post/user'.$userId, 0777, true, true);
        $photo = Input::file('file');
        $photo->move('images/post/user'.$userId, $photo->getClientOriginalName());
        return Response::json('user'.$userId.'/'.$photo->getClientOriginalName(),200);
	}
}