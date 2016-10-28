<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMDesaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('m_desa', function(Blueprint $table)
		{
			$table->foreign('m_kecamatan_id')->references('id')->on('m_kecamatan')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('m_desa', function(Blueprint $table)
		{
			$table->dropForeign('m_desa_m_kecamatan_id_foreign');
		});
	}

}
