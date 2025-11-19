<?php

namespace App\Models;

// Import yang saya tambahkan untuk relasi
use App\Models\TransaksiDetail; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; // Nama tabel di database
    protected $primaryKey = 'id_menu'; // Primary key tabel

    /**
     * Properti $fillable ini dari rekan Anda (untuk Menu Management)
     */
    protected $fillable = [
        'gambar_menu',
        'nama_menu',
        'stok_menu',
        'deskripsi_menu',
        'kategori_menu',
        'harga_menu',
    ];

    // --- MODIFIKASI DARI SAYA ---
    // Baris ini penting agar tidak error saat create/update,
    // karena tabel 'menu' Anda tidak punya kolom created_at/updated_at.
    public $timestamps = false;


    // ---HALAMAN PENDAPATAN ---

    /**
     * Relasi: Satu Menu ada di banyak TransaksiDetail.
     */
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_menu', 'id_menu');
    }
}