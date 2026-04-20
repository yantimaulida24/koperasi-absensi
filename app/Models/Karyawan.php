<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';
    protected $primaryKey = 'id_karyawan';

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'nik_karyawan',
        'id_jabatan',
        'nama_karyawan',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telepon',
        'alamat',
        'kode_qr',
    ];

    /**
     * Auto generate kode_qr setelah data dibuat
     */
    protected static function booted()
    {
        static::created(function ($karyawan) {
            if (empty($karyawan->kode_qr)) {
                $karyawan->updateQuietly([
                    'kode_qr' => 'KRY-' . $karyawan->id_karyawan
                ]);
            }
        });
    }

    /**
     * Relasi ke tabel jabatans
     */
    public function jabatan()
    {
        return $this->belongsTo(
            Jabatan::class,
            'id_jabatan',
            'id_jabatan'
        );
    }

    /**
     * Relasi ke tabel absensis
     */
    public function absensis()
    {
        return $this->hasMany(
            Absensi::class,
            'id_karyawan',
            'id_karyawan'
        );
    }

    /**
     * 🔥 TAMBAHAN: Relasi ke tabel users
     */
    public function user()
    {
        return $this->hasOne(
            User::class,
            'id_karyawan',
            'id_karyawan'
        );
    }
}