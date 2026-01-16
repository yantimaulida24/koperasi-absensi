<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_karyawan',   // ✅ SESUAI DATABASE
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(
            Karyawan::class,
            'id_karyawan',   // ✅ FK di tabel absensis
            'id_karyawan'    // ✅ PK di tabel karyawans
        );
    }
}
