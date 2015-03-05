<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('Posts', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->integer('usuario_id');
                $tabla->integer('seccion_id');
                $tabla->string('titulo', 100);
                $tabla->string('slug', 100);
                $tabla->text('cuerpo');
                $tabla->string('fuente',100);
                $tabla->string('urlFuente');
                $tabla->boolean('estado');
                $tabla->string('imagen', 100);
                
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
            Schema::drop('Posts');
	}

}
