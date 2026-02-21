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
        'id_karyawan',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'total_jam_kerja', // ✅ INI YANG HILANG
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(
            Karyawan::class,
            'id_karyawan',
            'id_karyawan'
        );
    }
}