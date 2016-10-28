<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMIndikatorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_indikator', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_kategori_indikator_id')->unsigned()->index('m_indikator_m_kategori_indikator_id_foreign');
			$table->string('name')->unique();
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
		Schema::drop('m_indikator');
	}

}
