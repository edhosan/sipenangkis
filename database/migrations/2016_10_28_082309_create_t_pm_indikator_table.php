<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTPmIndikatorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_pm_indikator', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('t_pmp_id')->unsigned()->index('t_pm_indikator_t_pmp_id_foreign');
			$table->integer('value')->unsigned()->nullable();
			$table->timestamps();
			$table->integer('m_indikator_id')->unsigned()->index('t_pm_indikator_m_indikator_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_pm_indikator');
	}

}
