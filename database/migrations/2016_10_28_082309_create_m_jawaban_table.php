<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMJawabanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_jawaban', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 200);
			$table->integer('nilai')->unsigned();
			$table->integer('m_indikator_id')->unsigned()->index('m_jawaban_m_indikator_id_foreign');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_jawaban');
	}

}
