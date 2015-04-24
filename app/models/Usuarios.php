<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuarios extends Eloquent implements UserInterface{

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usuarios';
    
    protected $fillabe = array(
                               'email',
                               'password'
                                );
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public static $rules = array(
                                'username' => 'required|unique:usuarios,usuario|min:5|max:12',
                                'email' => 'required|email|unique:usuarios,email',
                                'password' => 'required|min:8|max:30|alpha_dash',
                                'password_confirmation' => 'required|same:password'
                                );

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
