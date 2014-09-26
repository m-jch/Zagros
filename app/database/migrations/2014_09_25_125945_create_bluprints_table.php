<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBluprintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blueprints', function(Blueprint $table)
		{
			$table->increments('blueprint_id');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('milestone_id')->unsigned();
			$table->foreign('milestone_id')->references('milestone_id')->on('milestones')->onDelete('cascade')->onUpdate('cascade');
			$table->string('title', 200);
			$table->text('description')->nullable();
			$table->smallInteger('status');
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
		Schema::drop('blueprints');
	}

}
