<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMPenerimaManfaatKeluargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_penerima_manfaat_keluarga', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('m_penerima_manfaat_id')->unsigned()->index('m_penerima_manfaat_keluarga_m_penerima_manfaat_id_foreign');
			$table->string('nik')->nullable();
			$table->string('nama')->nullable();
			$table->enum('sex', array('L','P'));
			$table->date('tgl_lhr')->nullable();
			$table->string('tempat_lhr')->nullable();
			$table->enum('agama', array('1','2','3','4','5','6'));
			$table->enum('status', array('1','2','3','4','5'));
			$table->enum('hubungan', array('01','02','03','04','05','06','07','08','09','10','11'));
			$table->string('hubungan_ket')->nullable();
			$table->enum('akta_nikah', array('1','2'));
			$table->enum('kartu_identitas', array('0','1','2','3','4'));
			$table->enum('disabilitas_jenis', array('00','01','02','03','04','05'));
			$table->enum('disabilitas_kategori', array('1','2','3'));
			$table->string('penyakit_kronis')->nullable();
			$table->string('nama_sekolah')->nullable();
			$table->timestamps();
			$table->integer('m_pekerjaan_id')->unsigned()->index('m_pekerjaan_id');
			$table->integer('m_pendidikan_id')->unsigned()->index('m_penerima_manfaat_keluarga_m_pendidikan_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_penerima_manfaat_keluarga');
	}

}
