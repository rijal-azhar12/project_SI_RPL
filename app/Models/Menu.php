<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; // Nama tabel di database
    protected $primaryKey = 'id_menu'; // Primary key tabel

    protected $fillable = [
        'gambar_menu',
        'nama_menu',
        'stok_menu',
        'deskripsi_menu',
        'kategori_menu',
        'harga_menu',
    ];

    // Jika Anda tidak menggunakan timestamp (created_at, updated_at)
    // public $timestamps = false;
}
