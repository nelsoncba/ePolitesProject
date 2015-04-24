<?php

class RegisterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	   
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
		$validator = Validator::make(Input::all(), Usuarios::$rules);
		if($validator->fails()){
			return Response::json($validator->messages(),403);
		}else{
			$confirmToken = str_random(30);

			$usuario = new Usuarios;
			$usuario->usuario = Input::get('username');
			$usuario->email = Input::get('email');
			$usuario->password = Hash::make(Input::get('password'));
			$usuario->confirmation_token = $confirmToken;
			$usuario->enabled = false;
			

			if($usuario->save()){
				Mail::send('emails.confirmRegister', ['confirmToken'=>$confirmToken,
													  'username'=>Input::get('username'),
													  'email'=>Input::get('email'),
													  'password'=>Input::get('password')], function($message){
			        $message->to(Input::get('email'), Input::get('username'))->subject('Bienvenido a WebBlog');
			    });

				return Response::json(array('message'=>'Se ha registrado correctamente. Ingrese a su correo para confirmar su registro.'),202);	
			}else{
				return Response::json(array('message'=>'Hubo un inconveniente en el servidor, intentelo nuevamente.'),403);	
			}
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

	public function confirm($confirmToken){
		$usuario = Usuarios::whereConfirmationToken($confirmToken)->first();
		if(isset($usuario) && !$usuario->enabled){
			$usuario->enabled = true;
			$usuario->confirmation_token = null;
			if($usuario->save()){
				return Response::json(array('message'=>'La cuenta se ha habilitado con éxito.',
											'user' => $usuario));
			}

		}else{
			 return  Response::json(array('message'=>'Clave inválida o usuario ya ha sido validado.De no ser así, reenvíe nuevamente el email para activar la cuenta.'), 403);
		}
	}


}
