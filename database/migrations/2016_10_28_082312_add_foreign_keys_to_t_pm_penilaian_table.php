<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTPmPenilaianTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t_pm_penilaian', function(Blueprint $table)
		{
			$table->foreign('m_kluster_id')->references('id')->on('m_kluster')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('m_pm_id')->references('id')->on('m_penerima_manfaat')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t_pm_penilaian', function(Blueprint $table)
		{
			$table->dropForeign('t_pm_penilaian_m_kluster_id_foreign');
			$table->dropForeign('t_pm_penilaian_m_pm_id_foreign');
		});
	}

}
