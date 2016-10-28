<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMTujuanIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_tujuan_intervensi', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_intervensi_id')->unsigned()->index('m_tujuan_intervensi_m_intervensi_id_foreign');
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
		Schema::drop('m_tujuan_intervensi');
	}

}
