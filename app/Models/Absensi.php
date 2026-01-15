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
        'karyawan_id',   // ✅ SESUAI MIGRASI
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(
            Karyawan::class,
            'karyawan_id',   // FK di absensis
            'id_karyawan'    // PK di karyawans
        );
    }
}