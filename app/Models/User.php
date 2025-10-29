<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',     // ✅ tambahkan ini agar bisa digunakan di middleware cekRole
        'kode_qr',  // untuk QR unik tiap karyawan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===========================
    // Relasi ke tabel absensi
    // ===========================
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    // ===========================
    // Relasi ke tabel permohonan cuti
    // ===========================
    public function cuti()
    {
        return $this->hasMany(PermohonanCuti::class, 'id_karyawan', 'id');
    }
}