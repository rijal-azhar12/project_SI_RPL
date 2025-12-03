<?php

namespace App\Models;

use App\Models\TransaksiDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'gambar_menu',
        'nama_menu',
        'stok_menu',
        'deskripsi_menu',
        'kategori_menu',
        'harga_menu',
    ];

    public $timestamps = false;

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_menu', 'id_menu');
    }
}