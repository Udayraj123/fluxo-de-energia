<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function(Blueprint $table)
        {
            $table->timestamps();
            $table->increments('id');
            $table->string('username');
            $table->string('password', 128);
        });

        Schema::create('gods', function(Blueprint $table)
        {
            $table->timestamps();
            $table->increments('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('life_energy');
        });

        Schema::create('farmers', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name1');
            $table->string('name2');
            $table->bigInteger('contact1');
            $table->bigInteger('contact2');
            $table->string('email1');
            $table->string('email2');
            $table->enum('squad', ['JUNIOR', 'HAUTS']);
            $table->string('roll');
            $table->enum('language', ['hi', 'en'])->default('en');
            $table->integer('school_id');
            $table->integer('city_id');
            $table->integer('centre_id');
            $table->boolean('paid')->default(false);
            $table->string('user_id');
            $table->string('password', 128);
            $table->rememberToken();
            $table->integer('year');
            $table->string('comments');
            $table->softDeletes();
        });

        Schema::create('investors', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('address');
            $table->integer('pincode');
            $table->string('email');
            $table->string('contact');
            $table->integer('city_id');
            $table->boolean('verified')->default(false);
            $table->string('comments');
            $table->softDeletes();
        });

        Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('region', ['NORTH', 'SOUTH', 'WEST', 'CENTRAL', 'EAST']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
