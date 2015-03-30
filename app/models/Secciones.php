<?php

class Secciones extends Eloquent{
    protected $table = 'Secciones';

    protected $fillabe = array('seccion');
    
    //protected $with = array('posts');

    public function posts(){
        return $this->hasMany('Posts', 'seccion_id');
    }
    
    public static function getSections(){
    	$sections = DB::table('Secciones')
    	                ->leftJoin('Posts', 'Secciones.id','=','Posts.seccion_id')
    		            ->select('Secciones.id as id','Secciones.slug as slug', 'Secciones.seccion as seccion',DB::raw('COUNT(Posts.id) as count'))
    		            ->groupBy('Secciones.id')
    		            ->get();
    	return $sections;
    }

}
