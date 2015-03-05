<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Respuestas', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->integer('usuario_id');
                $tabla->integer('comentario_id');
                $tabla->text('respuesta');
                $tabla->boolean('estado');
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
		Schema::drop('Respuestas');
	}

}
