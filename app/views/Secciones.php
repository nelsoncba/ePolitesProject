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
    	                ->leftJoin('Posts', 'secciones.id','=','Posts.seccion_id')
    		            ->select('secciones.id as id','secciones.slug as slug', 'secciones.seccion as seccion',DB::raw('COUNT(Posts.id) as count'))
    		            ->groupBy('secciones.id')
    		            ->get();
    	return $sections;
    }

}
