<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_intervensi', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_intervensi_id')->unsigned()->index('t_intervensi_m_intervensi_id_foreign');
			$table->integer('tahun')->unsigned();
			$table->integer('penerima_id')->unsigned();
			$table->string('penerima_type');
			$table->string('rujukan');
			$table->string('userid');
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
		Schema::drop('t_intervensi');
	}

}
