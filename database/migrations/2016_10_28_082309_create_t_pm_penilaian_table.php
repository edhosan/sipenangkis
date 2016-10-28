<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTPmPenilaianTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_pm_penilaian', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_pm_id')->unsigned()->index('t_pm_penilaian_m_pm_id_foreign');
			$table->integer('nilai')->nullable();
			$table->string('kriteria', 30)->nullable();
			$table->timestamps();
			$table->integer('m_kluster_id')->unsigned()->nullable()->index('t_pm_penilaian_m_kluster_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_pm_penilaian');
	}

}
