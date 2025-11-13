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
            $table->integer('id_menu');
            $table->text('gambar_menu');
            $table->string('nama_menu', 256);
            $table->integer('stok_menu');
            $table->text('deskripsi_menu');
            $table->enum('kategori_menu', ['Makanan', 'Minuman', '', '']);
            $table->integer('harga_menu');

            // Indexes

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