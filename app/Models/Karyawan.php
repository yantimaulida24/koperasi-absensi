<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_jabatan',
        'nama_karyawan',
        'no_telepon',
        'alamat',
        'kode_qr', // ✅ boleh diisi oleh sistem
    ];

    /**
     * Auto-generate kode QR saat create
     */
    protected static function booted()
    {
        static::creating(function ($karyawan) {
            // ❗ belum ada id, jadi jangan di sini
        });

        static::created(function ($karyawan) {
            // 1x query, tanpa loop event
            $karyawan->kode_qr = 'KRY-' . $karyawan->id_karyawan;
            $karyawan->saveQuietly(); // ✅ tanpa trigger event lagi
        });
    }

    /**
     * Relasi ke tabel jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    /**
     * Relasi ke absensi
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'karyawan_id', 'id_karyawan');
    }
}