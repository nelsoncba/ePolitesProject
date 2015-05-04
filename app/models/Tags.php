<?php

class Tags extends Eloquent{
    
    protected $table = 'tags';
    protected $fillable = array('post_id', 'tag');
    
    
    public function posts(){
        return $this->belongsToMany('Posts_Tags');
    }
    
    //function return only values tag in array
    public static function selectValues(){
    	$tags = DB::table('tags')->select('tag')->get();

    	$values = array();
    	foreach ($tags as $key => $tag) {
    		$values[] = $tag->tag;
    	}

    	return $values;
    }
}

