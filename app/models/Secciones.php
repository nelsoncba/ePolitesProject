<?php

class Secciones extends Eloquent{
    protected $table = 'secciones';

    protected $fillabe = array('seccion');
    
    //protected $with = array('posts');

    public function posts(){
        return $this->hasMany('Posts', 'seccion_id');
    }
    
    public static function getSections(){
    	$sections = DB::table('secciones')
    	                ->leftJoin('posts', 'secciones.id','=','posts.seccion_id')
    		            ->select('secciones.id as id','secciones.slug as slug', 'secciones.seccion as seccion',DB::raw('COUNT(posts.id) as count'))
    		            ->groupBy('secciones.id')
    		            ->get();
    	return $sections;
    }

}
