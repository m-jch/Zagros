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
			$table->increments('user_id');
			$table->string('email', 100)->unique();
			$table->string('nickname', 20);
			$table->string('password', 200);
			$table->boolean('admin');
			$table->string('projects_admin_id', 500);
			$table->string('projects_write_id', 500);
			$table->string('prohects_read_id', 500);
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
		Schema::drop('users');
	}

}
