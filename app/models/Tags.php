<?php

class Tags extends Eloquent{
    
    protected $table = 'Tags';
    protected $fillable = array('post_id', 'tag');
    
    
    public function posts(){
        return $this->belongsToMany('Posts_Tags');
    }
    
}

