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
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('child_cat_id')->nullable();
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->integer('rentang');

            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('child_cat_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('asets');
    }
};
