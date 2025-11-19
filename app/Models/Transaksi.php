<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false; // tanggal_transaksi BUKAN timestamps Laravel

    protected $fillable = [
        'id_user', 'tanggal_transaksi',
    ];

    /**
     * Relasi: Satu Transaksi dimiliki oleh satu User (Kasir).
     */
    public function user()
    {
        // foreignKey, ownerKey
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: Satu Transaksi memiliki banyak TransaksiDetail.
     */
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi', 'id_transaksi');
    }
}