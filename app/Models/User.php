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
        'role',
        'id_karyawan', // ✅ TAMBAHAN
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
    // 🔥 RELASI KE KARYAWAN (WAJIB)
    // ===========================
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
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
        return $this->hasMany(PermohonanCuti::class, 'id_karyawan', 'id_karyawan');
    }
}