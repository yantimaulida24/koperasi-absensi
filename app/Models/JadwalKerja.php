<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'jadwal_kerjas';

    // Primary key
    protected $primaryKey = 'id_jadwal';

    // Kolom yang dapat diisi
    protected $fillable = [
        'hari_kerja',
        'jam_masuk',
        'jam_keluar',
    ];
}