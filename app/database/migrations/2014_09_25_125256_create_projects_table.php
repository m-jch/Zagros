<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('project_id');
			$table->string('name', 100);
			$table->string('repository', 500)->nullable();
			$table->text('description')->nullable();
			$table->string('admins', 500)->nullable();
			$table->string('writers', 500)->nullable();
			$table->string('readers', 500)->nullable();
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
		Schema::drop('projects');
	}

}
