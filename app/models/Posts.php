<?php

class Posts extends Eloquent{
    
    protected $table = 'Posts';
    protected $fillabe = array(
                               'usuario_id',
                               'seccion_id',
                               'titulo',
                               'slug',
                               'cuerpo',
                               'fuente',
                               'urlFuente',
                               'imagen'
                                );
    //protected $with = array('secciones','usuarios');


    public function comentarios()
    {
        return $this->hasMany('Comentarios', 'post_id');
    }
    
    public function tags()
    {
        return $this->belongsToMany('Posts_Tags');
    }
    
    public function secciones(){
        return $this->belongsTo('Secciones', 'seccion_id');
    }

    public function usuarios(){
        return $this->belongsTo('Usuarios', 'usuario_id');
    }

    public static function selectAll(){
        $posts = DB::table('Posts')
                               ->leftJoin('Secciones','Secciones.id', '=' ,'Posts.seccion_id')
                               ->leftJoin('Usuarios', 'Usuarios.id', '=', 'Posts.usuario_id')
                               ->leftJoin('Comentarios','Comentarios.post_id','=','Posts.id')
                               ->select(DB::raw('COUNT(Comentarios.id) as count'),'Posts.id as id','Posts.titulo as titulo', 'Posts.slug as slug','Posts.imagen as imagen', DB::raw('concat(SUBSTRING_INDEX(Posts.cuerpo," ",100),"...") as cuerpo'),'Secciones.seccion as seccion', 'Usuarios.usuario as usuario')
                               ->groupBy('Posts.id')
                               ->get();
        
        return $posts; 
    }

    public static function getPost($id){
        $post = DB::table('Posts')
                               ->leftJoin('Secciones','Secciones.id', '=' ,'Posts.seccion_id')
                               ->leftJoin('Usuarios', 'Usuarios.id', '=', 'Posts.usuario_id')
                               ->leftJoin('Posts_Tags', 'Posts_Tags.post_id', '=', 'Posts.id')
                               ->leftJoin('Tags','Posts_Tags.tag_id', '=', 'Tags.id')
                               ->select('Posts.id as id','Posts.titulo as titulo', 'Posts.slug as slug', 'Posts.imagen as imagen', 'Posts.created_at as created_at', DB::raw('GROUP_CONCAT(Tags.tag) as tag'), 'Posts.cuerpo as cuerpo', 'Secciones.seccion as seccion', 'Usuarios.usuario as usuario')
                               ->where('Posts.id','=',$id)
                               ->groupBy('Posts.id')
                               ->get();
        
        foreach ($post as  $p) {
            
            $data = array(  
                            'id' => $p->id,      
                            'titulo'=> $p->titulo,
                            'slug' => $p->slug,
                            'cuerpo' => $p->cuerpo,
                            'imagen' => $p->imagen,
                            'created_at' => $p->created_at,
                            'tag'=> explode(',', $p->tag),
                            'seccion' => $p->seccion,
                            'usuario' => $p->usuario
                            );
        }

        return $data;
    }

    public static function getRecent(){
        $posts = DB::table('Posts')
                            ->leftJoin('Secciones','Secciones.id','=','Posts.seccion_id')
                            ->leftJoin('Comentarios','Comentarios.post_id','=','Posts.id')
                            ->select(DB::raw('COUNT(Comentarios.id) as count'),'Posts.id as id','Posts.titulo as titulo', 'Posts.slug as slug','Posts.created_at as created_at','Posts.imagen as imagen', 'Secciones.seccion as seccion')
                            ->groupBy('Posts.id')
                            ->orderBy('created_at','DESC')
                            ->limit(10)
                            ->get();
        return $posts;
    }

    public static function crearPost($input){
        $respuesta = array();
        
        $reglas = array(
            'seccion_id' => 'required',
            'titulo' => array('required', 'max:100'),
            'cuerpo' => array('required'),
            'fuente' => array('required', 'max:100'),
            'urlFuente' => array('required', 'max:255'),
        );
        
        $validator = Validator::make($input, $reglas);
        
        if($validator->fails()){
            $respuesta['message'] = $validator;
            $respuesta['error'] = true;
        }else{
            $post = static::create($input);
            $respuesta['mensaje'] = 'Publicación creada correctamente';
            $respuesta['error'] = false;
            $respuesta['data'] = $post;
        }
        
        return $respuesta;
        
    }


}


