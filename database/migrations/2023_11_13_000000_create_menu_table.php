<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->text('gambar_menu');
            $table->string('nama_menu', 255);
            $table->integer('stok_menu')->default(0);
            $table->text('deskripsi_menu')->nullable();
            $table->enum('kategori_menu', ['Makanan', 'Minuman']);
            $table->integer('harga_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}