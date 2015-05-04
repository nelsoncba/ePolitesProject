<?php

class AuthenticationController extends \BaseController {
	private $restful =  true;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Auth::logout();
		return Response::json(['flash'=>'Sessión cerrada.'],202);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$credentials = array(
							'email' => Input::get('email'),
							'password' => Input::get('password'),
							);
		if(Auth::attempt($credentials)){
			if(Auth::user()->enabled == false)
				return Response::json(['flash'=>'Debe ingresar a su correo y habilitar su cuenta.'],403);
			else
				return Response::json(['user'=> Auth::user()->toArray()], 200);
		}else{
			return Response::json(['flash' => 'Usuario / clave incorrectos'],403);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function sendMail($to){
		if($to == 'resetPassword'){
			$usuario = Usuarios::where('email','=', Input::get('email'))->first();

			$confirmToken = str_random(30);
			
			if($usuario){
				$username = $usuario->usuario;
				$usuario->confirmation_token = $confirmToken;

				if($usuario->save()){
					Mail::send('emails.resetPassword', ['confirmToken'=>$confirmToken,'username' => $username], function($message){
						$message->to(Input::get('email'))->subject('Reseteo de contraseña');
					});

					return Response::json(array('message' => 'Se ha enviado un correo para resetear su contraseña, revise su casilla.'),200);
				}
			}else{
				return Response::json(array('message' => 'El email no se corresponde con un usuario registrado.' ),403);
			}

		}
	}

	public function verifyResetPassword($token){
		$usuario = Usuarios::where('confirmation_token','=',$token)->first();
		if($usuario){
			return Response::json(array('confirmation_token' => $usuario->confirmation_token, 'usuario_id'=>$usuario->id), 200);
		}else{
			return Response::json(array('message' => 'La clave no es válida, intente reenviando un nuevo email.'),403);
		}
	}

	public function resetPassword(){
		$validator = Validator::make(Input::all(), Usuarios::$rulesResetPassword);
		if($validator->fails()){
			return Response::json($validator->messages(),403);
		}else{
			$usuario = Usuarios::where('id','=',Input::get('id'))->first();
			$email = $usuario['email'];
			$usuario->password = Hash::make(Input::get('password'));
			$usuario->confirmation_token = null;

			if($usuario->save()){
				Mail::send('emails.confirmationResetPassword', ['username' => $usuario->usuario, 'email' => $usuario->email, 'password'=>Input::get('password')], function($message) use ($email){
					$message->to($email)->subject('Confirmación de reseteo de contraseña');
				});

				return Response::json(array('message'=>'La contraseña se ha modificado exitosamente. Se le ha enviado un email con los datos.'),200);
			}else{
				return Response::json(array('message'=>'No se ha podido modificar la contraseña intente reenviando nuevo email para reseteo.'),403);
			}

		}

	}
}
