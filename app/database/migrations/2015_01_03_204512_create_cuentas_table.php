<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('Cuentas', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->integer('usuario_id');
                $tabla->string('nombre',50);
                $tabla->string('apellido',50);
                $tabla->string('telefono',20);
                $tabla->dateTime('fechaNacimiento');
                $tabla->string('ocupacion',100);
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
            Schema::drop('Cuentas');
	}

}
