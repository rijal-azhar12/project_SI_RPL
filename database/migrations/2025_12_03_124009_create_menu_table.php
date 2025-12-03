<?php

namespace Database\Migrations;

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
            $table->bigInteger('id_menu')->nullable();
            $table->longText('gambar_menu')->nullable(false);
            $table->string('nama_menu', 255)->nullable();
            $table->integer('stok_menu')->nullable();
            $table->text('deskripsi_menu')->nullable();
            $table->enum('kategori_menu', [])->nullable();
            $table->integer('harga_menu')->nullable();
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
