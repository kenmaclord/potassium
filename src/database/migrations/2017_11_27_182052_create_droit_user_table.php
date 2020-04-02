<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDroitUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droit_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('droit_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('droit_id')
                ->references('id')->on('droits')
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
        Schema::table('droit_user', function (Blueprint $table) {
            $table->dropForeign('droit_id');
            $table->dropForeign('user_id');
        });

        Schema::dropIfExists('droit_user');
    }
}
