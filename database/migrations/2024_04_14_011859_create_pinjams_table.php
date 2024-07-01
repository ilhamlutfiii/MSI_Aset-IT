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
        Schema::create('pinjams', function (Blueprint $table) {
            $table->id();
            $table->string('pinjam_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('aset_id')->nullable();
            $table->unsignedBigInteger('main_id')->nullable();
            $table->integer('quantity');
            $table->enum('status', ['Baru', 'Diproses', 'Siap Diambil', 'Telah Diambil','Dikembalikan', 'Dibatalkan','Cek Kondisi Aset','Selesai'])->default('Baru');
            $table->string('photoStatus')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('aset_id')->references('id')->on('asets')->onDelete('cascade');
            $table->foreign('main_id')->references('id')->on('maintenances')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pinjams');
    }
};
