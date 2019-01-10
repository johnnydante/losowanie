<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Suggestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->increments('id')->unsigned()->unique();
            $table->integer('userId')->unsigned()->unique();
            $table->string('first', 255)->nullable();
            $table->string('second', 255)->nullable();
            $table->string('third', 255)->nullable();
			$table->timestamps();
        });

        Schema::table('suggestions', function (Blueprint $table) {
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            $table->dropForeign('userId');
        });
        Schema::dropIfExists('suggestions');
    }
}
