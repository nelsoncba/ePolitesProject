<?php

class Comentarios extends Eloquent{
    
    protected $table = 'Comentarios';
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
    
    public static function findComments($postId){
        $comments = DB::table('Comentarios')
                            ->leftJoin('Respuestas','Respuestas.comentario_id','=','Comentarios.id')
                            ->leftJoin('Usuarios','Usuarios.id','=','Comentarios.usuario_id')
                            ->where('Comentarios.post_id','=',$postId)
                            ->select('Comentarios.*','Usuarios.usuario as usuario','Usuarios.photo as photoUser',DB::raw('count(Respuestas.id) as respuestasTotal'))
                            ->groupBy('Comentarios.id')
                            ->get();
        return $comments;
    }

    public static function crearComentario($input){
        $respuesta = array();
        
        $reglas = array(
            'comentario' => array('required', 'max:500'),
        );
        
        $validator = Validator::make($input, $reglas);
        
        if($validator->fails()){
            $respuesta['message'] = $validator;
            $respuesta['error'] = true;
        }else{
            $comentario = static::create($input);
            $respuesta['mensaje'] = 'Ok';
            $respuesta['error'] = false;
            $respuesta['data'] = $comentario;
        }
        
        return $respuesta;
    }
}

