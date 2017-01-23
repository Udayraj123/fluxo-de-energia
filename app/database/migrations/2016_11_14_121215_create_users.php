<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//make changes to DB
		Schema::create('users',function($table){
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->enum('type',Config::get('preset.types'));
			//roles depts can be put in roles table
			$table->string('remember_token');
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
		//revert the changes to DB. The UNDO method
		Schema::drop('users');
	}

}
