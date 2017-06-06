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
        Schema::create('centres', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('address', 1000);
            $table->integer('pincode');
            $table->integer('city_id');
            $table->integer('code');
            $table->integer('strength');
            $table->integer('filled');
            $table->enum('online', ['YES', 'NO']);
            $table->string('comments');
        });

        Schema::create('cities', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('code');
            $table->unsignedInteger('state_id');
            $table->enum('region', ['NORTH', 'SOUTH', 'EAST', 'WEST', 'CENTRAL']);
            $table->string('comments');
            $table->timestamps();
        });

        Schema::create('cityreps', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('contact_home');
            $table->bigInteger('contact_iitg');
            $table->string('email');
            $table->string('webmail');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->enum('gender', ['MALE', 'FEMALE'])->default('MALE');
            $table->string('password', 128);
            $table->rememberToken();
            $table->tinyInteger('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->string('comments');
        });

        Schema::create('registrations', function(Blueprint $table)
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

        Schema::create('schools', function(Blueprint $table)
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

        Schema::create('states', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('region', ['NORTH', 'SOUTH', 'WEST', 'CENTRAL', 'EAST']);
        });

        Schema::create('faqs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('question', 1000);
            $table->string('answer', 10000);
            $table->integer('priority');
        });

        Schema::create('feedback', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('suggestion', 10000);
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

	}

}
