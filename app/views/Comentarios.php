<?php

class Comentarios extends Eloquent{
    
    protected $table = 'comentarios';
    protected $fillabe = array(
                               'usuario_id',
                               'post_id',
                               'comentario',
                                );
    protected $with = array('usuarios');
    
    public function posts()
    {
        return $this->belongsToMany('posts');
    }

    public function usuarios(){
        return $this->belongsTo('usuarios');
    }

    public function respuestas(){
        return $this->hasMany('respuestas', 'comentario_id');
    }
    
    public static function findComments($postId){
        $comments = DB::table('comentarios')
                            ->leftJoin('respuestas','respuestas.comentario_id','=','comentarios.id')
                            ->leftJoin('usuarios','usuarios.id','=','comentarios.usuario_id')
                            ->where('comentarios.post_id','=',$postId)
                            ->select('comentarios.*','usuarios.usuario as usuario','usuarios.photo as photoUser',DB::raw('count(respuestas.id) as respuestasTotal'))
                            ->groupBy('comentarios.id')
                            ->get();
        return $comments;
    }

    public static function lastComment($id){
        $comment = DB::table('comentarios')
                            ->leftJoin('respuestas','respuestas.comentario_id','=','comentarios.id')
                            ->leftJoin('usuarios','usuarios.id','=','comentarios.usuario_id')
                            ->where('comentarios.usuario_id','=',$id)
                            ->select('comentarios.*','usuarios.usuario as usuario','usuarios.photo as photoUser',DB::raw('count(respuestas.id) as respuestasTotal'))
                            ->groupBy('comentarios.id')
                            ->orderBy('comentarios.created_at','DESC')
                            ->limit('1')
                            ->get();
        return $comment;
    }

}

