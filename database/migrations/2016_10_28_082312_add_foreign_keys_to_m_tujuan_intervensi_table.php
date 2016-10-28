<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMTujuanIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_tujuan_intervensi', function(Blueprint $table)
		{
			$table->foreign('m_intervensi_id')->references('id')->on('m_intervensi')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_tujuan_intervensi', function(Blueprint $table)
		{
			$table->dropForeign('m_tujuan_intervensi_m_intervensi_id_foreign');
		});
	}

}
