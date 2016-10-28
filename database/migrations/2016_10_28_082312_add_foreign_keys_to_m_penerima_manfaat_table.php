<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMPenerimaManfaatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_penerima_manfaat', function(Blueprint $table)
		{
			$table->foreign('m_desa_id')->references('id')->on('m_desa')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_penerima_manfaat', function(Blueprint $table)
		{
			$table->dropForeign('m_penerima_manfaat_m_desa_id_foreign');
		});
	}

}
