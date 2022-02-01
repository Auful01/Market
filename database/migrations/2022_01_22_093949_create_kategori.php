<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->bigIncrements('id_kategori');
            $table->unsignedBigInteger('id_komoditas');
            $table->string('nama_kategori');
            $table->string('satuan');
            $table->integer('harga_normal');
            $table->foreign('id_komoditas')->references('id_komoditas')->on('komoditas');
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
        Schema::dropIfExists('kategori');
    }
}
