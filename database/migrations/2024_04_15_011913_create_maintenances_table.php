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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aset_id');            
            $table->integer('rentang');
            $table->unsignedBigInteger('pinjam_id')->nullable();            
            $table->text('ket_main')->nullable();
            $table->enum('mainStatus',['Diperbaiki','Sedang Diproses','Maintenance','Selesai','Repair']);
            $table->string('mainPhoto')->nullable();
            $table->timestamps();

            $table->foreign('aset_id')->references('id')->on('asets')->onDelete('cascade');
            $table->foreign('pinjam_id')->references('id')->on('pinjams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
};
