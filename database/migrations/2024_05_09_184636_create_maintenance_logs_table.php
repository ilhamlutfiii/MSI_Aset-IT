<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_id');
            $table->unsignedBigInteger('aset_id');
            $table->foreign('maintenance_id')->references('id')->on('maintenances')->onDelete('cascade');
            $table->foreign('aset_id')->references('id')->on('asets')->onDelete('cascade');
            $table->string('status');
            $table->string('mainPhoto')->nullable();
            $table->text('ket_main')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
