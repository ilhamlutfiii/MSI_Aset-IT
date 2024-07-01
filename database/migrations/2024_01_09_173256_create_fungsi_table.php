<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fungsis', function (Blueprint $table) {
            $table->id('fungsi_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('fungsi_name');
            $table->timestamps();

            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fungsis', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
        });

        Schema::dropIfExists('fungsis');
    }
};
