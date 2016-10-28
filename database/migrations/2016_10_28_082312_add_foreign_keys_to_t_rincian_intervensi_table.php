<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTRincianIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t_rincian_intervensi', function(Blueprint $table)
		{
			$table->foreign('t_intervensi_id')->references('id')->on('t_intervensi')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t_rincian_intervensi', function(Blueprint $table)
		{
			$table->dropForeign('t_rincian_intervensi_t_intervensi_id_foreign');
		});
	}

}
