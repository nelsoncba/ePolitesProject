<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    	<h2></h2>
        <h3>Verifique su cuenta</h3>

        <div>
            Gracias por haberse unido a Webblog.
            Haga click en el link para confirmar su cuenta y comenzar a usar el servicio.<br><a href="{{ URL::to('http://localhost/polites/public/#/register-verify/' . $confirmToken) }}">
            {{ URL::to('register-verify/' . $confirmToken) }}</a><br/>

        </div><br>
        <div>
        	<p>Las credenciales de su cuenta son:<p>
        	<strong>Usuario:</strong> <small>{{$username}}</small><br>
           	<strong>Email:</strong> <small>{{$email}}</small><br>
        	<strong>Contraseña:</strong> <small>{{$password}}</small>
        </div>

    </body>
</html>