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
            $table->id('id_menu'); // Auto-incrementing primary key
            $table->text('gambar_menu'); // Changed to text for URL
            $table->string('nama_menu', 255); // Max length 255
            $table->integer('stok_menu')->default(0); // Default to 0
            $table->text('deskripsi_menu')->nullable(); // Made nullable
            $table->enum('kategori_menu', ['Drink', 'Food']); // Adjusted enum values
            $table->integer('harga_menu'); // Prices

            $table->timestamps(); // Adds created_at and updated_at columns
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