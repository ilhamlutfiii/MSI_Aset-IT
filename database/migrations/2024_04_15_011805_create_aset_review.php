<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('aset_id')->nullable();
            $table->unsignedBigInteger('pinjam_id')->nullable();
            $table->tinyInteger('rate')->default(0);
            $table->text('review')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->string('photoStatus')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('aset_id')->references('id')->on('asets')->onDelete('cascade');
            $table->foreign('pinjam_id')->references('id')->on('pinjams')->onDelete('cascade');
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
        Schema::dropIfExists('aset_reviews');
    }
};
