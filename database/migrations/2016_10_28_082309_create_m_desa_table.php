<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMDesaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_desa', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_kecamatan_id')->unsigned()->index('m_desa_m_kecamatan_id_foreign');
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
		Schema::drop('m_desa');
	}

}
