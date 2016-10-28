<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTIntervensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t_intervensi', function(Blueprint $table)
		{
			$table->foreign('m_intervensi_id')->references('id')->on('m_intervensi')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t_intervensi', function(Blueprint $table)
		{
			$table->dropForeign('t_intervensi_m_intervensi_id_foreign');
		});
	}

}
