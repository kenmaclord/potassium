<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraductionsContentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('traductions_content', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('traduction_id')->unsigned();
			$table->text('body')->nullable();
			$table->string('lang');
			$table->boolean('published');
			$table->timestamps();

			$table->foreign('traduction_id')
				->references('id')->on('traductions')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('traductions_content', function (BluePrint $table){
			$table->dropForeign(['traduction_id']);
		});

		Schema::dropIfExists('traductions_content');
	}
}
