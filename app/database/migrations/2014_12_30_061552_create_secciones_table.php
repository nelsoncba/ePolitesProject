<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('Secciones', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->string('seccion',40);
                $tabla->string('slug',40);
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
            Schema::drop('Secciones');
	}

}
