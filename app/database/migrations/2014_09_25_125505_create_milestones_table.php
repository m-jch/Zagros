<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('milestones', function(Blueprint $table)
		{
			$table->increments('milestone_id');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('projects');
			$table->string('codename', 100);
			$table->text('description')->nullable();
			$table->boolean('released');
			$table->string('version', 50)->nullable();
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
		Schema::drop('milestones');
	}

}
