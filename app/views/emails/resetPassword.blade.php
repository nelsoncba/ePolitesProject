<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    	<h2></h2>
        <h3>Reseteo de contraseña</h3>

        <div>
            Hola {{$username}}, este email tiene instrucciones para resetear su contraseña.
            Haga click en el link para poder hacer el reseteo de su contraseña.<br><a href="{{ URL::to('http://localhost/polites/public/#/verify-reset-password/' . $confirmToken) }}">
            {{ URL::to('verify-reset-password/' . $confirmToken) }}</a><br/>

        </div><br>

    </body>
</html>