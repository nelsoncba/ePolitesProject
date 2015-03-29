<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('Tags', function(Blueprint $tabla){
                $tabla->increments('id');
                $tabla->string('tag', 40);
                $tabla->string('slug', 40);
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
            Schema::drop('Tags');
	}

}

        
  