<?php

class Posts extends Eloquent{
    
    protected $table = 'posts';
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
    protected $with = array('secciones');

    public static $rules = array(
                                'title' => 'required|max:100',
                                'section' => 'required',
                                'content' => 'required|min:200',
                                'tags' => 'required',
                                );

    public function comentarios()
    {
        return $this->hasMany('Comentarios', 'post_id');
    }
    
    public function tags()
    {
        return $this->belongsToMany('Tags','Posts_Tags','post_id','tag_id');
    }
    
    public function secciones(){
        return $this->belongsTo('Secciones', 'seccion_id', 'slug');
    }

    public function usuarios(){
        return $this->belongsTo('Usuarios', 'usuario_id');
    }

    public static function selectAll(){
        $posts = DB::table('posts')
                               ->leftJoin('secciones','secciones.id', '=' ,'posts.seccion_id')
                               ->leftJoin('usuarios', 'usuarios.id', '=', 'posts.usuario_id')
                               ->leftJoin('comentarios','comentarios.post_id','=','posts.id')
                               ->select(DB::raw('COUNT(comentarios.id) as count'),'posts.id as id','posts.titulo as titulo', 'posts.slug as slug','posts.imagen as imagen', 'posts.cuerpo as cuerpo', 'posts.created_at as created_at', 'secciones.seccion as seccion', 'usuarios.usuario as usuario')
                               ->groupBy('posts.id')
                               ->orderBy('count','DESC')
                               ->orderBy('created_at','DESC')
                               ->get();
  
        return $posts; 
    }

    public static function bySection($slug){
        $posts = DB::table('posts')
                               ->leftJoin('secciones','secciones.id', '=' ,'posts.seccion_id')
                               ->leftJoin('usuarios', 'usuarios.id', '=', 'posts.usuario_id')
                               ->leftJoin('comentarios','comentarios.post_id','=','posts.id')
                               ->select(DB::raw('COUNT(comentarios.id) as count'),'posts.id as id','posts.titulo as titulo', 'posts.slug as slug','posts.imagen as imagen', 'posts.cuerpo as cuerpo', 'posts.created_at as created_at', 'secciones.seccion as seccion', 'usuarios.usuario as usuario')
                               ->where('secciones.slug','=', $slug)
                               ->groupBy('posts.id')
                               ->orderBy('count','DESC')
                               ->orderBy('created_at','DESC')
                               ->get();
  
        return $posts; 
    }

    public static function getPost($id){
        $data = null;
        $post = DB::table('posts')
                               ->leftJoin('secciones','secciones.id', '=' ,'posts.seccion_id')
                               ->leftJoin('usuarios', 'usuarios.id', '=', 'posts.usuario_id')
                               ->leftJoin('posts_tags', 'posts_tags.post_id', '=', 'posts.id')
                               ->leftJoin('tags','posts_tags.tag_id', '=', 'tags.id')
                               ->select('posts.id as id','posts.titulo as titulo', 'posts.slug as slug', 'posts.imagen as imagen', 'posts.created_at as created_at', DB::raw('GROUP_CONCAT(tags.tag) as tag'), 'posts.cuerpo as cuerpo', 'posts.urlFuente as urlFuente', 'posts.created_at as created_at', 'secciones.seccion as seccion', 'usuarios.usuario as usuario')
                               ->where('posts.id','=',$id)
                               ->groupBy('posts.id')
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
                            'urlFuente' => $p->urlFuente,
                            'seccion' => $p->seccion,
                            'usuario' => $p->usuario
                            );
        }

        return $data;
    }

    public static function getRecent(){
        $posts = DB::table('posts')
                            ->leftJoin('secciones','secciones.id','=','posts.seccion_id')
                            ->leftJoin('comentarios','comentarios.post_id','=','posts.id')
                            ->select(DB::raw('COUNT(comentarios.id) as count'),'posts.id as id','posts.titulo as titulo', 'posts.slug as slug','posts.created_at as created_at','posts.imagen as imagen', 'secciones.seccion as seccion')
                            ->groupBy('posts.id')
                            ->orderBy('created_at','DESC')
                            ->limit(10)
                            ->get();
        return $posts;
    }
}


