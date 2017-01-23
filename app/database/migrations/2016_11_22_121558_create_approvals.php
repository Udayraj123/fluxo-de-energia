<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('approvals',function($table){
			$table->increments('id');
			$fields=Config::get('preset.approval_fields');
			foreach($fields['tinyinteger'] as $si) $table->tinyinteger($si)->default(0);
			foreach($fields['string'] as $si) $table->string($si);
			foreach($fields['integer'] as $si) $table->integer($si);
			$table->enum('role',Config::get('preset.roles'));
			$table->timestamps();
		});
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('approvals');
		//
	}

}
