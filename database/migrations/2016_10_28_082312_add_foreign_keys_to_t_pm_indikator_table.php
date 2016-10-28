<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTPmIndikatorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t_pm_indikator', function(Blueprint $table)
		{
			$table->foreign('m_indikator_id')->references('id')->on('m_indikator')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('t_pmp_id')->references('id')->on('t_pm_penilaian')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t_pm_indikator', function(Blueprint $table)
		{
			$table->dropForeign('t_pm_indikator_m_indikator_id_foreign');
			$table->dropForeign('t_pm_indikator_t_pmp_id_foreign');
		});
	}

}
