<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMPenerimaManfaatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_penerima_manfaat', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_desa_id')->unsigned()->index('m_penerima_manfaat_m_desa_id_foreign');
			$table->string('rt')->nullable();
			$table->string('alamat');
			$table->string('no_rumah')->nullable();
			$table->integer('domisili')->unsigned();
			$table->string('nkk')->nullable()->unique('nkk');
			$table->timestamps();
			$table->string('userid')->nullable();
			$table->string('rw')->nullable();
			$table->string('refid', 15)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_penerima_manfaat');
	}

}
