<?php

namespace App\Models;

// Import yang saya tambahkan untuk relasi
use App\Models\Transaksi; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * [KOREKSI PENTING OLEH SAYA]
     * Baris 'public $incrementing = false;' dari file asli TELAH DIHAPUS.
     * Berdasarkan file .sql Anda, 'id_user' adalah AUTO_INCREMENT.
     * Membiarkan baris itu 'false' akan merusak fitur 'create user'.
     */

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // Ini sudah benar

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'nama',
        'peran',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // ---  HALAMAN PENDAPATAN ---

    /**
     * Relasi: Satu User (kasir) memiliki banyak Transaksi.
     */
    public function transaksi()
    {
        // foreignKey, localKey
        return $this->hasMany(Transaksi::class, 'id_user', 'id_user');
    }
}