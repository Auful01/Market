<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_harga', function (Blueprint $table) {
            $table->bigIncrements('id_info');
            $table->unsignedBigInteger('id_jenis_pasar');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('harga');
            $table->foreign('id_jenis_pasar')->references('id_jenis_pasar')->on('jenis_pasar')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
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
        Schema::dropIfExists('info_harga');
    }
}
