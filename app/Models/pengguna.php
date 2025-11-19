<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Nama class sekarang 'Pengguna'
class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // Tetap mengarah ke tabel 'user'
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    
    // ... (isi $fillable dan relasi lainnya) ...
}