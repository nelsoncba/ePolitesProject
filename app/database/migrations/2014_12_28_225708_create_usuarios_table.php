<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('Usuarios', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->string('usuario', 50);
                $tabla->string('email',100);
                $tabla->string('password', 50);
                $tabla->boolean('enabled');
                $tabla->integer('role');
                $tabla->timestamps();
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('Usuarios');
	}

}
