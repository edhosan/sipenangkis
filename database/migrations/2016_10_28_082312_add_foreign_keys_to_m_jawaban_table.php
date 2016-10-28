<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMJawabanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_jawaban', function(Blueprint $table)
		{
			$table->foreign('m_indikator_id')->references('id')->on('m_indikator')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_jawaban', function(Blueprint $table)
		{
			$table->dropForeign('m_jawaban_m_indikator_id_foreign');
		});
	}

}
