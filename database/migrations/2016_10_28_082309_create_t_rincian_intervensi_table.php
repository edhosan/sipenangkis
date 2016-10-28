<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTRincianIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_rincian_intervensi', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('t_intervensi_id')->unsigned()->index('t_rincian_intervensi_t_intervensi_id_foreign');
			$table->string('name');
			$table->integer('volume');
			$table->string('satuan');
			$table->integer('nilai');
			$table->integer('jumlah');
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
		Schema::drop('t_rincian_intervensi');
	}

}
