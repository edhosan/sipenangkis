<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_intervensi', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->timestamps();
			$table->integer('m_program_id')->unsigned()->index('m_intervensi_m_program_id_foreign');
			$table->integer('m_sasaran_intervensi_id')->unsigned()->index('m_intervensi_m_sasaran_intervensi_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_intervensi');
	}

}
