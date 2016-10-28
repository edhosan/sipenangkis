<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMProgramStakeholderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_program_stakeholder', function(Blueprint $table)
		{
			$table->foreign('m_program_id')->references('id')->on('m_program')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('m_stakeholders_id')->references('id')->on('m_stakeholders')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_program_stakeholder', function(Blueprint $table)
		{
			$table->dropForeign('m_program_stakeholder_m_program_id_foreign');
			$table->dropForeign('m_program_stakeholder_m_stakeholders_id_foreign');
		});
	}

}
