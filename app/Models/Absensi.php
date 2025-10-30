<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_absensi';
    protected $fillable = [
        'id_karyawan', 'tanggal', 'jam_masuk', 'jam_keluar', 'status'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    // Relasi tidak langsung ke jadwal kerja (berdasarkan jam)
    public function jadwalKerja()
    {
        return $this->hasOne(JadwalKerja::class, 'jam_masuk', 'jam_masuk')
                    ->whereColumn('jadwal_kerja.jam_keluar', 'absensi.jam_keluar');
    }
}
