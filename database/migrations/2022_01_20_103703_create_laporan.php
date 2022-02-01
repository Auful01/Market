<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->bigIncrements('id_laporan');
            $table->unsignedBigInteger('id_jenis_pasar');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_informasi_harga_pasar');
            $table->foreign('id_jenis_pasar')->references('id_jenis_pasar')->on('jenis_pasar')->onDelete('cascade');
            $table->foreign('id_informasi_harga_pasar')->references('id_informasi_harga_pasar')->on('informasi_harga_pasar')->onDelete('cascade');
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
        Schema::dropIfExists('laporan');
    }
}
