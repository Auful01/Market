<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformasiHargaPasar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informasi_harga_pasar', function (Blueprint $table) {
            $table->bigIncrements('id_informasi_harga_pasar');
            $table->string('komoditi');
            $table->string('satuan');
            $table->integer('rata_rata_kemarin');
            $table->integer('pasar_baru');
            $table->integer('rata_rata');
            $table->integer('perubahan_harga');
            $table->integer('harga_normal');
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
        Schema::dropIfExists('informasi_harga_pasar');
    }
}
