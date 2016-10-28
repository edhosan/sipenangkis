<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMSumberDanaProgramTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_sumber_dana_program', function(Blueprint $table)
		{
			$table->integer('m_sumber_dana_id')->unsigned();
			$table->integer('m_program_id')->unsigned()->index('m_sumber_dana_program_m_program_id_foreign');
			$table->primary(['m_sumber_dana_id','m_program_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_sumber_dana_program');
	}

}
