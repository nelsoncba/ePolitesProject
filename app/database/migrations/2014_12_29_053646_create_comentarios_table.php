<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('Comentarios', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->integer('usuario_id');
                $tabla->integer('post_id');
                $tabla->text('comentario');
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
            Schema::drop('Comentarios');
	}

}
