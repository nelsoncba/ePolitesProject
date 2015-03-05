<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcomentariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Subcomentarios', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->integer('usuario_id');
                $tabla->integer('comentario_id');
                $tabla->text('subcomentario');
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
		Schema::drop('Subcomentarios');
	}

}
