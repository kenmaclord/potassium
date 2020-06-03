<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traductions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('zone_id')->unsigned();
            $table->string('key');
            $table->text('content');
            $table->timestamps();

            $table->foreign('zone_id')
                ->references('id')->on('zones')
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
        Schema::table('traductions', function(Blueprint $table){
            $table->dropForeign(['zone_id']);
        });

        Schema::dropIfExists('traductions');
    }
}
