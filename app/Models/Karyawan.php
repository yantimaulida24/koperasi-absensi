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
        'kode_qr',
    ];

    /**
     * Auto-generate kode QR setelah data tersimpan
     */
    protected static function booted()
    {
        static::created(function ($karyawan) {
            if (!$karyawan->kode_qr) {
                $karyawan->updateQuietly([
                    'kode_qr' => 'KRY-' . $karyawan->id_karyawan
                ]);
            }
        });
    }

    /**
     * Relasi ke jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    /**
     * ✅ RELASI YANG BENAR (INI PENTING)
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_karyawan', 'id_karyawan');
    }
}