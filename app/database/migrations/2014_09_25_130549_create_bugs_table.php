<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBugsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bugs', function(Blueprint $table)
		{
			$table->increments('bug_id');
			$table->integer('user_id_created')->unsigned();
			$table->foreign('user_id_created')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('user_id_assigned')->unsigned();
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('milestone_id')->unsigned();
			$table->foreign('milestone_id')->references('milestone_id')->on('milestones')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('blueprint_id')->unsigned();
			$table->string('title', 200);
			$table->text('description');
			$table->smallInteger('type');
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
		Schema::drop('bugs');
	}

}
