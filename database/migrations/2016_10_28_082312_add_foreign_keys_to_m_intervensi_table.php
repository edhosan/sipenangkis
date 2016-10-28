<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_intervensi', function(Blueprint $table)
		{
			$table->foreign('m_program_id')->references('id')->on('m_program')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('m_sasaran_intervensi_id')->references('id')->on('m_sasaran_intervensi')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_intervensi', function(Blueprint $table)
		{
			$table->dropForeign('m_intervensi_m_program_id_foreign');
			$table->dropForeign('m_intervensi_m_sasaran_intervensi_id_foreign');
		});
	}

}
