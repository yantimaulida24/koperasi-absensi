<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis'; // pastikan nama tabel sesuai di database
    protected $primaryKey = 'id_absensi';
    public $timestamps = true;

    protected $fillable = [
        'id_karyawan',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];

    public function karyawan()
    {
        // 🟢 relasi yang benar (karena kolom di tabel Absensi adalah id_karyawan)
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
