<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMIndikatorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_indikator', function(Blueprint $table)
		{
			$table->foreign('m_kategori_indikator_id')->references('id')->on('m_kategori_indikator')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_indikator', function(Blueprint $table)
		{
			$table->dropForeign('m_indikator_m_kategori_indikator_id_foreign');
		});
	}

}
