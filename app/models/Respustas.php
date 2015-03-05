<?php

class Respuestas extends \Eloquent {
	protected $table = 'Respuestas';
	protected $fillable = [];

	public function comentarios(){
		return $this->belongsTo('Comentarios', 'comentario_id');
	}

	public function usuarios(){
		return $this->belongsTo('Usuarios', 'usuario_id');
	}
}