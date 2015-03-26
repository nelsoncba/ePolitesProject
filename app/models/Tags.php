<?php

class Tags extends Eloquent{
    
    protected $table = 'Tags';
    protected $fillable = array('post_id', 'tag');
    
    
    public function posts(){
        return $this->belongsToMany('Posts_Tags');
    }
    
    //function return only values tag in array
    public static function selectValues(){
    	$tags = DB::table('Tags')->select('tag')->get();

    	$values = array();
    	foreach ($tags as $key => $tag) {
    		$values[] = $tag->tag;
    	}

    	return $values;
    }
}

