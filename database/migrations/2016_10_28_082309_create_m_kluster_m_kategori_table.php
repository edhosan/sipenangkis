<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMKlusterMKategoriTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_kluster_m_kategori', function(Blueprint $table)
		{
			$table->integer('m_kluster_id')->unsigned();
			$table->integer('m_kategori_id')->unsigned()->index('m_kluster_m_kategori_m_kategori_id_foreign');
			$table->primary(['m_kluster_id','m_kategori_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_kluster_m_kategori');
	}

}
