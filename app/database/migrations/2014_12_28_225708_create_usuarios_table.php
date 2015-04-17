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
            Schema::create('Usuarios', function(Blueprint $table){
                $table->increments('id');
                $table->string('user', 50);
                $table->string('email',100);
                $table->string('password', 50);
                $table->boolean('enabled');
                $table->integer('role');
                $table->string('photo', 100);
                $table->string('remember_token', 100);
                $table->timestamps();
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
