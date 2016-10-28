<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMKlusterMKategoriTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_kluster_m_kategori', function(Blueprint $table)
		{
			$table->foreign('m_kategori_id')->references('id')->on('m_kategori_indikator')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('m_kluster_id')->references('id')->on('m_kluster')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_kluster_m_kategori', function(Blueprint $table)
		{
			$table->dropForeign('m_kluster_m_kategori_m_kategori_id_foreign');
			$table->dropForeign('m_kluster_m_kategori_m_kluster_id_foreign');
		});
	}

}
