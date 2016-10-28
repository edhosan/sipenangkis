<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMSumberDanaProgramTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_sumber_dana_program', function(Blueprint $table)
		{
			$table->foreign('m_program_id')->references('id')->on('m_program')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('m_sumber_dana_id')->references('id')->on('m_sumber_dana')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_sumber_dana_program', function(Blueprint $table)
		{
			$table->dropForeign('m_sumber_dana_program_m_program_id_foreign');
			$table->dropForeign('m_sumber_dana_program_m_sumber_dana_id_foreign');
		});
	}

}
