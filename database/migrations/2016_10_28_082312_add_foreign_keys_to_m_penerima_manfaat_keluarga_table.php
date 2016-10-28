<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMPenerimaManfaatKeluargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_penerima_manfaat_keluarga', function(Blueprint $table)
		{
			$table->foreign('m_pendidikan_id')->references('id')->on('m_pendidikan')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('m_penerima_manfaat_id')->references('id')->on('m_penerima_manfaat')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_penerima_manfaat_keluarga', function(Blueprint $table)
		{
			$table->dropForeign('m_penerima_manfaat_keluarga_m_pendidikan_id_foreign');
			$table->dropForeign('m_penerima_manfaat_keluarga_m_penerima_manfaat_id_foreign');
		});
	}

}
