<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('event_id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('milestone_id')->unsigned();
			$table->foreign('milestone_id')->references('milestone_id')->on('milestones')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('blueprint_id')->unsigned();
			$table->integer('bug_id')->unsigned();
			$table->smallInteger('type');
			$table->text('changes')->nullable();
			$table->text('description')->nullable();
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
		Schema::drop('events');
	}

}
