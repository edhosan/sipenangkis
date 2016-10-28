<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMProgramStakeholderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_program_stakeholder', function(Blueprint $table)
		{
			$table->integer('m_stakeholders_id')->unsigned();
			$table->integer('m_program_id')->unsigned()->index('m_program_stakeholder_m_program_id_foreign');
			$table->primary(['m_stakeholders_id','m_program_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_program_stakeholder');
	}

}
