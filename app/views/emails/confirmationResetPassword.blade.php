<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    	<h2></h2>
        <h3>Reseteo de contraseña</h3>

        <div>
            Hola {{$username}}, nos comunicamos para informar que se ha modificado correctamente su contraseña.<br><br>

            <p>Las credenciales de su cuenta son:<p>
        	<strong>Usuario:</strong> <small>{{$username}}</small><br>
           	<strong>Email:</strong> <small>{{$email}}</small><br>
        	<strong>Nueva Contraseña:</strong> <small>{{$password}}</small>

        </div><br>

    </body>
</html>