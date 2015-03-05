<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuarios extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Usuarios';
    
    protected $fillabe = array(
                               'usuario',
                               'email'
                                );
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function posts(){
        return $this->hasMany('Posts', 'usuario_id');
    }

    public function comentarios(){
    	return $this->hasMany('Comentarios', 'usuario_id');
    }

    public function respuestas(){
    	return $this->hasMany('Respuestas', 'usuario_id');
    }
}
