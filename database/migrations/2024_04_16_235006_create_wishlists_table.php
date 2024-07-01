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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aset_id');
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('quantity');
            
            $table->foreign('aset_id')->references('id')->on('asets')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('SET NULL');
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
        Schema::dropIfExists('wishlists');
    }
};
