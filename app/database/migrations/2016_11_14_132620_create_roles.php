<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles',function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->enum('role',Config::get('preset.roles'));
			$table->string('domain_field'); //'hostel' or 'department' or 'is_QIP' acc to role
			$table->string('domain_val'); //hostel name or department name or '1'/'0' acc to role
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
		//
		Schema::drop('roles');
	}

}
