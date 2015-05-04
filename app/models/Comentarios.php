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
        return $this->belongsToMany('Posts');
    }

    public function usuarios(){
        return $this->belongsTo('Usuarios');
    }

    public function respuestas(){
        return $this->hasMany('Respuestas', 'comentario_id');
    }

    public function likes(){
        return $this->hasOne('Likes', 'comentario_id');
    }
    
    public static function findComments($postId){
        $comments = DB::table('comentarios')
                            ->leftJoin('respuestas','respuestas.comentario_id','=','comentarios.id')
                            ->leftJoin('usuarios','usuarios.id','=','comentarios.usuario_id')
                            ->leftJoin('likes','likes.comentario_id','=','comentarios.id')
                            ->where('comentarios.post_id','=',$postId)
                            ->select('comentarios.*', 'likes.likes as likes','likes.unlikes as unlikes','usuarios.usuario as usuario','usuarios.photo as photoUser',DB::raw('count(respuestas.id) as respuestasTotal'))
                            ->groupBy('comentarios.id')
                            ->get();
        return $comments;
    }

    public static function lastComment($id){
        $comment = DB::table('comentarios')
                            ->leftJoin('respuestas','respuestas.comentario_id','=','comentarios.id')
                            ->leftJoin('usuarios','usuarios.id','=','comentarios.usuario_id')
                            ->leftJoin('likes','likes.comentario_id','=','comentarios.id')
                            ->where('comentarios.usuario_id','=',$id)
                            ->select('comentarios.*','likes.likes as likes','likes.unlikes as unlikes','usuarios.usuario as usuario','usuarios.photo as photoUser',DB::raw('count(respuestas.id) as respuestasTotal'))
                            ->groupBy('comentarios.id')
                            ->orderBy('comentarios.created_at','DESC')
                            ->limit('1')
                            ->get();
        return $comment;
    }

}

